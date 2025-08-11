/**
 * JWT Authentication Helper
 */
class JWTAuth {
    constructor() {
        this.baseURL = '/api/auth';
        this.tokenKey = 'jwt_token';
        this.userKey = 'user_data';
    }

    /**
     * Set authorization header for requests
     */
    getAuthHeaders() {
        const token = this.getToken();
        return {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            ...(token && { 'Authorization': `Bearer ${token}` })
        };
    }

    /**
     * Login user
     */
    async login(email, password) {
        try {
            const response = await fetch(`${this.baseURL}/login`, {
                method: 'POST',
                headers: this.getAuthHeaders(),
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (data.success) {
                this.setToken(data.access_token);
                this.setUser(data.user);
                return { success: true, data };
            } else {
                return { success: false, message: data.message, errors: data.errors };
            }
        } catch (error) {
            console.error('Login error:', error);
            return { success: false, message: 'Network error occurred' };
        }
    }

    /**
     * Register user
     */
    async register(name, email, password, passwordConfirmation) {
        try {
            const response = await fetch(`${this.baseURL}/register`, {
                method: 'POST',
                headers: this.getAuthHeaders(),
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation: passwordConfirmation
                })
            });

            const data = await response.json();

            if (data.success) {
                this.setToken(data.access_token);
                this.setUser(data.user);
                return { success: true, data };
            } else {
                return { success: false, message: data.message, errors: data.errors };
            }
        } catch (error) {
            console.error('Registration error:', error);
            return { success: false, message: 'Network error occurred' };
        }
    }

    /**
     * Logout user
     */
    async logout() {
        try {
            await fetch(`${this.baseURL}/logout`, {
                method: 'POST',
                headers: this.getAuthHeaders()
            });
        } catch (error) {
            console.error('Logout error:', error);
        } finally {
            this.clearAuth();
        }
    }

    /**
     * Get current user
     */
    async me() {
        try {
            const response = await fetch(`${this.baseURL}/me`, {
                method: 'GET',
                headers: this.getAuthHeaders()
            });

            const data = await response.json();

            if (data.success) {
                this.setUser(data.user);
                return { success: true, user: data.user };
            } else {
                if (response.status === 401) {
                    this.clearAuth();
                }
                return { success: false, message: data.message };
            }
        } catch (error) {
            console.error('Me error:', error);
            return { success: false, message: 'Network error occurred' };
        }
    }

    /**
     * Refresh token
     */
    async refreshToken() {
        try {
            const response = await fetch(`${this.baseURL}/refresh`, {
                method: 'POST',
                headers: this.getAuthHeaders()
            });

            const data = await response.json();

            if (data.success) {
                this.setToken(data.access_token);
                this.setUser(data.user);
                return { success: true, data };
            } else {
                this.clearAuth();
                return { success: false, message: data.message };
            }
        } catch (error) {
            console.error('Token refresh error:', error);
            this.clearAuth();
            return { success: false, message: 'Network error occurred' };
        }
    }

    /**
     * Update profile
     */
    async updateProfile(profileData) {
        try {
            const response = await fetch(`${this.baseURL}/profile`, {
                method: 'PUT',
                headers: this.getAuthHeaders(),
                body: JSON.stringify(profileData)
            });

            const data = await response.json();

            if (data.success) {
                this.setUser(data.user);
                return { success: true, user: data.user };
            } else {
                return { success: false, message: data.message, errors: data.errors };
            }
        } catch (error) {
            console.error('Profile update error:', error);
            return { success: false, message: 'Network error occurred' };
        }
    }

    /**
     * Change password
     */
    async changePassword(currentPassword, newPassword, newPasswordConfirmation) {
        try {
            const response = await fetch(`${this.baseURL}/password`, {
                method: 'PUT',
                headers: this.getAuthHeaders(),
                body: JSON.stringify({
                    current_password: currentPassword,
                    new_password: newPassword,
                    new_password_confirmation: newPasswordConfirmation
                })
            });

            const data = await response.json();
            return { success: data.success, message: data.message, errors: data.errors };
        } catch (error) {
            console.error('Password change error:', error);
            return { success: false, message: 'Network error occurred' };
        }
    }

    /**
     * Token management
     */
    setToken(token) {
        localStorage.setItem(this.tokenKey, token);
    }

    getToken() {
        return localStorage.getItem(this.tokenKey);
    }

    removeToken() {
        localStorage.removeItem(this.tokenKey);
    }

    /**
     * User data management
     */
    setUser(user) {
        localStorage.setItem(this.userKey, JSON.stringify(user));
    }

    getUser() {
        const userData = localStorage.getItem(this.userKey);
        return userData ? JSON.parse(userData) : null;
    }

    removeUser() {
        localStorage.removeItem(this.userKey);
    }

    /**
     * Clear all auth data
     */
    clearAuth() {
        this.removeToken();
        this.removeUser();
    }

    /**
     * Check if user is authenticated
     */
    isAuthenticated() {
        return !!this.getToken();
    }

    /**
     * Check if token is expired (basic check)
     */
    isTokenExpired() {
        const token = this.getToken();
        if (!token) return true;

        try {
            const payload = JSON.parse(atob(token.split('.')[1]));
            const currentTime = Date.now() / 1000;
            return payload.exp < currentTime;
        } catch (error) {
            return true;
        }
    }

    /**
     * Auto refresh token if needed
     */
    async autoRefreshToken() {
        if (this.isAuthenticated() && this.isTokenExpired()) {
            const result = await this.refreshToken();
            if (!result.success) {
                this.clearAuth();
                window.location.href = '/jwt/login';
            }
        }
    }
}

// Create global instance
window.jwtAuth = new JWTAuth();

// Auto refresh token on page load
document.addEventListener('DOMContentLoaded', function() {
    if (window.jwtAuth.isAuthenticated()) {
        window.jwtAuth.autoRefreshToken();
    }
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = JWTAuth;
}