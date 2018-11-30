<div class="container">
    <?php if (!empty($errors))
        foreach ($errors as $error)
            echo '<div class="col"><div class="alert alert-danger">' . $error . '</div></div>'; ?>
    <form action="index.php?controller=login&action=login" method="post">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required />
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
