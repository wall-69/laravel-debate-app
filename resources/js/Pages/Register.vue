<template>
    <div class="grow flex flex-col items-center gap-4 justify-center">
        <h2 class="text-primary text-3xl font-bold">Zaregistrujte sa</h2>
        <fieldset class="fieldset w-xs bg-base-200 p-4 rounded-box">
            <!-- Meno -->
            <label class="fieldset-label">Meno</label>
            <input type="text" class="input" placeholder="Meno" />

            <!-- Email -->
            <label class="fieldset-label">Email</label>
            <input type="email" class="input" placeholder="Email" />

            <!-- Password -->
            <label class="fieldset-label">Heslo</label>
            <input type="password" class="input" placeholder="Heslo" />

            <!-- Password confirmation -->
            <label class="fieldset-label">Potvrďte heslo</label>
            <input type="password" class="input" placeholder="Potvrďte heslo" />

            <!-- TOS -->
            <label class="fieldset-label">
                <input type="checkbox" class="w-4 h-4" />
                Súhlasím s podmienkami používania
            </label>

            <button class="btn btn-neutral mt-4">Registrovať</button>
        </fieldset>
    </div>
</template>
