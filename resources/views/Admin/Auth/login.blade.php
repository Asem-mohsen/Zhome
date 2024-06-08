<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <div>
        <label>Email</label>
        <input type="email" name="Email" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="Password" required>
    </div>
    <div>
        <button type="submit">Login</button>
    </div>
</form>
