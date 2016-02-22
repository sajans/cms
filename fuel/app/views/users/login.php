

<div class="container">
    <div class="row">
        <div class="form-group">
            <h3>Login</h3>
            <br>
            <br>
            <?php echo Form::open(array('action' => Uri::create('users/login'), 'method' => 'post')); ?>
            <?php echo Form::label('email', 'Email', array()) ?>
            <?php echo Form::input('email', '', array()) ?>
            <br>
            <?php echo Form::label('password', 'Password', array()) ?>

            <?php echo Form::input('password', '', array()) ?>
            <br>
            <?php echo Form::submit('login', 'Login', array()) ?>
            <br>
            <br>
            <br>    
        </div>
    </div>

</div>
<style>
    .form-group{margin:0px auto;}  

</style>