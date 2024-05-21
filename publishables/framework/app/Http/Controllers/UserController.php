<?php

namespace App\Http\Controllers;

use Aboleon\MetaFramework\Actions\Suppressor;
use Aboleon\MetaFramework\Services\Passwords\PasswordBroker;
use Aboleon\MetaFramework\Services\Validation\ValidationTrait;
use App\Enum\UserType;
use App\Http\Requests\BackendUserRequest;
use App\Models\{User, UserProfile, UserRole};
use App\Notifications\SendPasswordNotification;
use App\Traits\Users;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Throwable;

class UserController extends Controller
{
    use SoftDeletes;
    use Users;
    use ValidationTrait;

    public function index(string $role): Renderable
    {
        if ($role == 'dev' && !auth()->user()->hasRole('dev')) {
            $role = 'forbidden';
        }
        return view()->first(['roles.index_' . $role, 'users.index'])->with([
            'data' => User::withRole($role)
                ->when(Route::currentRouteName() == 'aboleon-framework.users.archived', fn($q) => $q->onlyTrashed())
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->paginate(15),
            'role' => $role,
            'archived' => request()->routeIs('aboleon-framework.users.archived'),
        ]);
    }


    public function create(?string $role = null): Renderable
    {
        $account = new User;

        $parsed_role = $role ? collect($this->user_roles())->filter(fn($item, $key) => $key == $role)->values()->first() : [];

        return view('users.add')->with([
            'account' => $account,
            'roles' => $this->userTypes(),
            'role' => $parsed_role,
            'route' => route('aboleon-framework.users.store'),
            'label' => 'Nouveau compte ' . ($parsed_role['label'] ?? '')
        ]);
    }

    public function edit(User $user): Renderable
    {
        return view('users.add')->with([
            'account' => $user,
            'roles' => $user->userTypes(),
            'method' => 'put',
            'route' => route('aboleon-framework.users.update', $user),
            'label' => 'Éditer un compte',
        ]);
    }

    public function store(BackendUserRequest $request): RedirectResponse
    {
        try {

            $this->ensureDataIsValid($request, 'user');

            if ($this->hasErrors()) {
                return $this->sendResponse();
            }

            $password_broker = (new PasswordBroker(request()))->passwordBroker();
            $this->validated_data['user']['password'] = $password_broker->getEncryptedPassword();
            $this->validated_data['user']['type'] = UserType::SYSTEM->value;
            $this->responseNotice($password_broker->printPublicPassword());

            $user = User::create($this->validated_data['user']);

            if (request()->has('send_password_by_mail')) {
                $this->pushMessages(
                    (new SendPasswordNotification($password_broker, $user))()
                );
            }

            if (request()->filled('roles')) {
                $roles = [];
                foreach (request('roles') as $role) {
                    $roles[] = (new UserRole(['role_id' => $role]));
                }
                $user->roles()->saveMany($roles);
            }
            $user->processMedia();
            if (request()->has('profile')) {
                $user->profile()->save(new UserProfile($this->validated_data['profile']));
            }

            $this->responseSuccess(__('aboleon-framework.record_created'));
            $this->redirect_to = route('aboleon-framework.users.edit', $user->id);
            $this->saveAndRedirect(route('aboleon-framework.users.index', 'super-admin'));

        } catch (Throwable $e) {
            $this->responseException($e);
        }
        return $this->sendResponse();
    }

    public function update(User $user): RedirectResponse
    {
        $validation = new BackendUserRequest($user);
        $this->validation_rules = $validation->rules();
        $this->validation_messages = $validation->messages();

        $this->validation();

        try {
            # Manage password change
            $password_broker = (new PasswordBroker(request()));
            if ($password_broker->requestedChange()) {
                $this->validated_data['user']['password'] = $password_broker->getEncryptedPassword();
                $this->responseNotice($password_broker->printPublicPassword());
                if (request()->has('send_password_by_mail')) {
                    $this->pushMessages(
                        (new SendPasswordNotification($password_broker, $user))()
                    );
                }
            }

            $user->update($this->validated_data['user']);
            $user->processRoles();

            if (request()->has('profile')) {
                $user->profile()->update($this->validated_data['profile']);
            }
            $user->processMedia();

            if ($password_broker->requestedChange() && $user->id == auth()->id()) {
                Auth::guard('web')->logout();
                session()->flush();
                Auth::guard('web')->login($user);
            }
            $this->saveAndRedirect(route('aboleon-framework.users.index', 'super-admin'));
            $this->responseSuccess(__('aboleon-framework.record_updated'));

        } catch (Throwable $e) {
            $this->responseException($e);
        }
        return $this->sendResponse();
    }

    /**
     * @throws \Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        return (new Suppressor($user))
            ->remove()
            ->whitout('object')
            ->responseSuccess(__('Le compte est archivé.'))
            ->sendResponse();
    }
}
