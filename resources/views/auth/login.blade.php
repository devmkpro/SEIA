<x-guest-layout>
    <div class="conteiner">

        
        <div class="text-dark-seia card" style="width: 25rem">
            <div class="d-flex justify-content-center align-items-center my-5">
                <img src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg" alt="logo" class="w-50">
            </div>
            <form method="POST" action="{{ route('login') }}" class="card-body d-flex flex-column align-items-center justify-content-center">
                @csrf
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-white bg-danger rounded p-2" style="width:  15rem" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-white bg-danger rounded p-2" style="width:  15rem"/>
                
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="d-block w-full my-1 form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"  style="width: 15em"/>
                </div>
        
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
        
                    <x-text-input id="password" class="d-block w-full my-1 form-control"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" 
                                    style="width: 15em"
                                    />
        
                </div>
    
        
                <div class="mt-4">                
                        <button type="submit" class="btn btn-seia-darkblue mb-5" style="width: 15rem">
                            {{ __('Log in') }}
                        </button>
                </div>
            </form>
            
        </div>
    </div>
</x-guest-layout>
