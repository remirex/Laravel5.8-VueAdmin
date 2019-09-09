<template>
    <div class="cont">
        <div class="form sign-in">
            <h2>Welcome back,</h2>
            <label>
                <span>Email</span>
                <input type="email" class="form-control" name="email" v-model="login.email"
                       :class="{ 'is-invalid': login.errors.has('email') }" @keydown="login.onKeydown($event)">
                <has-error :form="login" field="email"></has-error>
            </label>
            <label>
                <span>Password</span>
                <input type="password"  name="password" v-model="login.password" class="form-control"
                       :class="{ 'is-invalid': login.errors.has('password') }" @keydown="login.onKeydown($event)">
                <has-error :form="login" field="password"></has-error>
            </label>
            <p class="forgot-pass">Forgot password?</p>
            <button type="button" class="submit" @click="userLogin">Sign In</button>
            <button type="button" class="fb-btn">Connect with <span>facebook</span></button>
        </div>
        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                    <h2>New here?</h2>
                    <p>Sign up and discover great amount of new opportunities!</p>
                </div>
                <div class="img__text m--in">
                    <h2>One of us?</h2>
                    <p>If you already has an account, just sign in. We've missed you!</p>
                </div>
                <div class="img__btn">
                    <span class="m--up">Sign Up</span>
                    <span class="m--in">Sign In</span>
                </div>
            </div>
            <div class="form sign-up">
                <h2>Time to feel like home,</h2>
                <label>
                    <span>Name</span>
                    <input type="text" name="name" v-model="create.name" class="form-control"
                           :class="{ 'is-invalid': create.errors.has('name') }" @keydown="create.onKeydown($event)"/>
                    <has-error :form="create" field="name"></has-error>
                </label>
                <label>
                    <span>Email</span>
                    <input type="email" class="form-control" name="email" v-model="create.email"
                           :class="{ 'is-invalid': create.errors.has('email') }" @keydown="create.onKeydown($event)">
                    <has-error :form="create" field="email"></has-error>
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" class="form-control" name="password" v-model="create.password"
                           :class="{ 'is-invalid': create.errors.has('password') }" @keydown="create.onKeydown($event)">
                    <has-error :form="create" field="password"></has-error>
                </label>
                <label>
                    <span>Password Confirmation</span>
                    <input type="password" name="password_confirmation" v-model="create.password_confirmation">
                </label>
                <button type="button" class="submit" @click="createAccount">Sign Up</button>
                <button type="button" class="fb-btn">Join with <span>facebook</span></button>
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
              })
          }
        },
        methods: {
            createAccount() {
                this.create.post('/register')
                    .then(() => {
                        window.location.href = '/home'
                    })
                    .catch(() => {
                        toast.fire({
                            type: 'error',
                            title: 'There was something wrong.'
                        })
                    })
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
                    .catch(() => {
                        toast.fire({
                            type: 'error',
                            title: 'There was something wrong.'
                        })
                    })
            }
        },
        name: "AccountForm"
    }
</script>

<style scoped>

</style>