@php
    $error = $errors->any();
@endphp

<div class="col-xl-6 mb-3">
    <x-aboleon-inputable::input name="user[first_name]" :label="__('aboleon-framework-account.first_name')" :value="$error ? old('user.first_name') : $account->first_name"/>
</div>
<div class="col-xl-6 mb-3">
    <x-aboleon-inputable::input name="user[last_name]"  :label="__('aboleon-framework-account.last_name')" :value="$error ? old('user.last_name') : $account->last_name"/>
</div>
<div class="col-lg-12 mb-3">
    <x-aboleon-inputable::input name="user[email]" type="email" :label="__('aboleon-framework.email_address')" :value="$error ? old('user.email') : $account->email"/>
</div>
