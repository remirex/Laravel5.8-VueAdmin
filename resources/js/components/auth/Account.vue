<template>
    <div class="account-wrapper d-flex">
        <div class="account-request">
            <div class="form">
                <p class="message mb-2 text-left"><a href="/"><i class="fas fa-arrow-left fa-2x"></i></a> </p>
                <!-- Signup form -->
                <div class="signup">
                    <h3 class="heading-color">Create An Account</h3>
                    <div class="form-group">
                        <input type="text" name="name" v-model="create.name" placeholder="name" class="form-control"
                               :class="{ 'is-invalid': create.errors.has('name') }" @keydown="create.onKeydown($event)">
                        <has-error :form="create" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" v-model="create.email" placeholder="email address" class="form-control"
                               :class="{ 'is-invalid': create.errors.has('email') }" @keydown="create.onKeydown($event)">
                        <has-error :form="create" field="email"></has-error>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" v-model="create.password" placeholder="password" class="form-control"
                               :class="{ 'is-invalid': create.errors.has('password') }" @keydown="create.onKeydown($event)">
                        <has-error :form="create" field="password"></has-error>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" v-model="create.password_confirmation" placeholder="confirm password" class="form-control"/>
                    </div>
                    <button @click="createAccount">create</button>
                    <p class="message">Already registered? <a href="#" id="login">Sign In</a></p>
                </div><!--./Signup form-->
                <!-- Signin form -->
                <div class="signin">
                    <h3 class="mb-3 heading-color">Log Into LaravelApp</h3>
                    <div class="form-group">
                        <input type="email" name="email" v-model="login.email" placeholder="email" class="form-control"
                               :class="{ 'is-invalid': login.errors.has('email') }" @keydown="login.onKeydown($event)">
                        <has-error :form="login" field="email"></has-error>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" v-model="login.password" placeholder="password" class="form-control"
                               :class="{ 'is-invalid': login.errors.has('password') }" @keydown="login.onKeydown($event)">
                        <has-error :form="login" field="password"></has-error>
                    </div>
                    <button @click="userLogin">login</button>
                    <p class="message">Not registered? <a href="#" id="create">Create an account</a></p>
                    <p class="message"><a href="#" id="forgot">Forgot password?</a></p>
                </div><!--./Signin form-->
                <!-- Forgot password -->
                <div class="forgot">
                    <h3 class="heading-color">Forgot your password</h3>
                    <p class="mb-3 text-white">Enter the email address associated with your account.<br>
                        We will email you a link with instructions on how to reset your password.</p>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="email address" class="form-control"
                               :class="{ 'is-invalid': forgot.errors.has('email') }" @keydown="forgot.onKeydown($event)">
                        <has-error :form="forgot" field="email"></has-error>
                    </div>
                    <button>send</button>
                    <p class="message"><a href="#" id="login2">Sign In</a></p>
                </div><!--./Forgot password-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                create: new Form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }),
                login: new Form({
                    email: '',
                    password: ''
                }),
                forgot: new Form({
                    email: ''
                })
            }
        },
        methods: {
            createAccount() {
                this.create.post('/register')
                    .then()
                    .catch()
            },
            userLogin() {
                this.login.post('/login')
                    .then(response => {
                        if(response.data === 'admin'){
                            window.location.href = '/dashboard'
                        } else {
                            window.location.href = '/home'
                        }
                    })
                    .catch()
            }
        },
        name: "Account"
    }

    $( document ).ready(function() {
        console.log( "ready!" );
        $('#create').click(function(){
            $('.signin').animate({height: "toggle", opacity: "toggle"}, "slow");
            $('.signup').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
        $('#login').click(function(){
            $('.signup').animate({height: "toggle", opacity: "toggle"}, "slow");
            $('.signin').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
        $('#forgot').click(function(){
            $('.forgot').animate({height: "toggle", opacity: "toggle"}, "slow");
            $('.signin').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
        $('#login2').click(function(){
            $('.forgot').animate({height: "toggle", opacity: "toggle"}, "slow");
            $('.signin').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
    });

</script>

<style scoped>

</style>