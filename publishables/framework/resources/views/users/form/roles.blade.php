<div class="d-none">
    @if (!isset($role) && request()->route()->getName() != 'aboleon-framework.users.create_type')
        <div class="col-lg-12 mb-3 mt-4">
            <div class="d-flex align-align-items-center mb-4">
                <b class="d-block">Rôles</b>
                <x-aboleon-framework::devmark/>
            </div>

            @if(!auth()->user()->hasRole('dev'))
                @php
                    $roles = array_filter($roles, function($item, $key) { return $key !== 'dev';}, ARRAY_FILTER_USE_BOTH);
                @endphp
            @endif

            @foreach($roles as $role_key => $role)
                <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox"
                           id="roles_{{ $role_key }}" name="roles[]"
                           value="{{ $role['id'] }}"
                        {{ $account && $account->hasRole($role_key) ? 'checked':
        (!$account && $role == 'super-admin' ? 'checked' :'') }} />
                    <label class="form-check-label" for="roles_{{ $role_key }}">
                        {{ __('aboleon-framework-usertype.'.$role_key.'.label') }}
                    </label>
                </div>
            @endforeach
        </div>
    @else
        <input type="hidden" name="roles[]" value="{{ $role['id'] ?? '' }}"/>
    @endif
</div>
