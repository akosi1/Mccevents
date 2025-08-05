<x-guest-layout>
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-header">
                <h1>Create an Account</h1>
                <p>Join EventAps to get started</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input 
                        id="first_name" 
                        type="text" 
                        name="first_name" 
                        value="{{ old('first_name') }}" 
                        placeholder="First Name" 
                        required 
                        autofocus 
                        autocomplete="given-name"
                    >
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input 
                        id="middle_name" 
                        type="text" 
                        name="middle_name" 
                        value="{{ old('middle_name') }}" 
                        placeholder="Middle Name (Optional)" 
                        autocomplete="additional-name"
                    >
                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                </div>

                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input 
                        id="last_name" 
                        type="text" 
                        name="last_name" 
                        value="{{ old('last_name') }}" 
                        placeholder="Last Name" 
                        required 
                        autocomplete="family-name"
                    >
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Email Address" 
                        required 
                        autocomplete="username"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder="Password" 
                        required 
                        autocomplete="new-password"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="Confirm Password" 
                        required 
                        autocomplete="new-password"
                    >
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i>
                    {{ __('Register') }}
                </button>

                <div class="auth-links">
                    <p>{{ __('Already registered?') }} <a href="{{ route('login') }}">{{ __('Sign in here') }}</a></p>
                </div>
            </form>
        </div>
    </div>

    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 40px 30px;
            position: relative;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 2px;
        }

        .auth-header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 300;
        }

        .auth-header p {
            opacity: 0.9;
            font-size: 1rem;
        }

        .auth-form {
            padding: 40px 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.1rem;
            z-index: 1;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.15);
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.3);
        }

        .auth-links {
            text-align: center;
            color: #6c757d;
        }

        .auth-links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .auth-links a:hover {
            color: #764ba2;
        }

        /* Error message styling */
        .text-red-600 {
            color: #e53e3e;
            font-size: 0.875rem;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 480px) {
            .auth-container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .auth-form {
                padding: 30px 20px;
            }
            
            .auth-header {
                padding: 30px 20px;
            }
        }
    </style>
</x-guest-layout>