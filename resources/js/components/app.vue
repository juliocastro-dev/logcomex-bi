<template> 
    <div v-if="isAuthenticated" class="flex justify-between p-4 shadow-gray-600 bg-white border">
        <h1>LOGCOMEX BI</h1>
        <nav>
            <div>
                <router-link class="link" to="/dashboard">Dashboard</router-link>
                <button @click="logout">Logout</button>
            </div>
        </nav>
    </div>
    <main>
        <router-view />
    </main>
</template>
<script>
    export default {
        data() {
            return {
                isAuthenticated: false,
            };
        },
        created() {
            this.checkAuth();
        },
        watch: {
            $route() {
                this.checkAuth();
            }
        },
        methods: {
            checkAuth() {
                this.isAuthenticated = !!localStorage.getItem('access_token');
                if (!this.isAuthenticated && this.$route.name !== 'Login') {
                    this.$router.push({ name: 'Login' })
                }
            },
            logout() {
                localStorage.removeItem('access_token');
                this.isAuthenticated = false;
                this.$router.push({ name: 'Login' })
            }
        }
    }
</script>