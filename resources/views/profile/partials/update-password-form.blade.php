<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="form-group">
        <label for="update_password_current_password">{{ __('Current Password') }}</label>
        <input id="update_password_current_password" name="current_password" type="password"
            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
            autocomplete="current-password" />
        @error('current_password', 'updatePassword')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="update_password_password">{{ __('New Password') }}</label>
        <input id="update_password_password" name="password" type="password"
            class="form-control @error('password', 'updatePassword') is-invalid @enderror"
            autocomplete="new-password" />
        @error('password', 'updatePassword')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password"
            class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
            autocomplete="new-password" />
        @error('password_confirmation', 'updatePassword')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-2">
        <button type="submit" class="btn btn-warning"><i class="fas fa-key mr-1"></i> {{ __('Save') }}</button>

        @if (session('status') === 'password-updated')
            <span class="text-success small ml-2"><i class="fas fa-check"></i> {{ __('Saved.') }}</span>
        @endif
    </div>
</form>