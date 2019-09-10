<template>
    <div class="cont">
        <div>
            <h2 class="mt-5">Reset Password</h2>
        </div>
        <div>
            <label>
                <span>Email</span>
                <input type="email" class="form-control" name="email" v-model="form.email"
                       :class="{ 'is-invalid': form.errors.has('email') }" @keydown="form.onKeydown($event)" readonly>
                <has-error :form="form" field="email"></has-error>
            </label>
            <label>
                <span>Password</span>
                <input type="password" class="form-control" name="password" v-model="form.password"
                       :class="{ 'is-invalid': form.errors.has('password') }" @keydown="form.onKeydown($event)">
                <has-error :form="form" field="password"></has-error>
            </label>
            <label>
                <span>Password Confirmation</span>
                <input type="password" name="password_confirmation" v-model="form.password_confirmation">
            </label>
        </div>
        <div>
            <button type="button" class="submit" @click="reset">Reset Password</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
              form: new Form ({
                  token: this.$route.params.token,
                  email: this.$route.query.email,
                  password: '',
                  password_confirmation: ''
              })
          }  
        },
        methods: {
            reset() {
                this.form.post('/password/reset')
                    .then(() => {
                        window.location.href = '/home'
                    })
                    .catch(() => {
                        toast.fire({
                            type: 'error',
                            title: 'There was something wrong.'
                        })
                    })
            }
        },
        name: "Reset"
    }
</script>

<style scoped>

</style>