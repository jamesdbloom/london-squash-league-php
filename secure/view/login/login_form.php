<form action='<?php echo Link::Login_Url; ?>' method='post'>

    <input type='hidden' name='redirect_to' value="<?php echo LoginViewHelper::redirect_url(); ?>"/>

    <div class="login_form">
        <p>
            <label class='email' for='email'>E-mail:</label>
            <input id='email' class='show_validation' type='email' name='email' value="<?php echo Form::escape_and_sanitize_field_value(Cookies::get_cookie_value(Cookies::REMEMBER_ME_COOKIE_NAME)); ?>" size='35' autocorrect=”off” autocapitalize=”off” autocomplete=”off” required='required'
                   pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" tabindex='10'/>
        </p>

        <p>
            <label class='password' for='password'>Password:</label>
            <input id='password' class='show_validation' type='password' name='password' value='' autocorrect=”off” autocapitalize=”off” autocomplete=”off” required='required' tabindex='10'/>
        </p>

        <p>
            <label class='remember_me' for='remember_me'>Remember:</label>
            <input id='remember_me' name='remember_me' type='checkbox' value='forever' tabindex='20'<?php echo Form::checked(strlen(Cookies::get_cookie_value(Cookies::REMEMBER_ME_COOKIE_NAME)) > 0); ?> />
        </p>

        <p class='submit'>
            <input class='submit' type='submit' name='submit' value='Login' tabindex='100'/>
        </p>
    </div>
</form>