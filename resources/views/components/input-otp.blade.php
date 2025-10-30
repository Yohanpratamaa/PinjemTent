@props([
    'digits' => 6,
    'name' => 'otp',
    'wire:model' => null,
    'x-model' => null,
    'autocomplete' => 'one-time-code',
])

<div class="flex justify-center space-x-2" x-data="otpInput(@js($digits))">
    @for($i = 0; $i < $digits; $i++)
        <flux:input
            type="text"
            maxlength="1"
            {{ $attributes->whereStartsWith('wire:') }}
            @if($attributes->has('x-model'))
                x-model="inputs[{{ $i }}]"
            @endif
            x-ref="input{{ $i }}"
            x-on:input="handleInput($event, {{ $i }})"
            x-on:keydown="handleKeydown($event, {{ $i }})"
            x-on:paste="handlePaste($event)"
            autocomplete="{{ $autocomplete }}"
            inputmode="numeric"
            pattern="[0-9]*"
            class="w-12 h-12 text-center text-lg font-semibold"
        />
    @endfor

    {{-- Hidden input to store the complete OTP value --}}
    <input
        type="hidden"
        name="{{ $name }}"
        @if($attributes->has('wire:model'))
            {{ $attributes->whereStartsWith('wire:') }}
        @endif
        x-model="value"
    />
</div>

<script>
function otpInput(digits) {
    return {
        inputs: Array(digits).fill(''),
        value: '',

        init() {
            this.$watch('inputs', (newInputs) => {
                this.value = newInputs.join('');
            });
        },

        handleInput(event, index) {
            const value = event.target.value;

            if (value && /^\d$/.test(value)) {
                this.inputs[index] = value;

                // Move to next input if not last
                if (index < digits - 1) {
                    this.$refs[`input${index + 1}`].focus();
                }
            } else {
                // Clear invalid input
                this.inputs[index] = '';
                event.target.value = '';
            }
        },

        handleKeydown(event, index) {
            // Handle backspace
            if (event.key === 'Backspace') {
                if (this.inputs[index] === '' && index > 0) {
                    // Move to previous input if current is empty
                    this.$refs[`input${index - 1}`].focus();
                } else {
                    // Clear current input
                    this.inputs[index] = '';
                }
            }
            // Handle left/right arrow keys
            else if (event.key === 'ArrowLeft' && index > 0) {
                this.$refs[`input${index - 1}`].focus();
            }
            else if (event.key === 'ArrowRight' && index < digits - 1) {
                this.$refs[`input${index + 1}`].focus();
            }
        },

        handlePaste(event) {
            event.preventDefault();
            const pastedData = event.clipboardData.getData('text');
            const numbers = pastedData.replace(/\D/g, '').slice(0, digits);

            for (let i = 0; i < digits; i++) {
                this.inputs[i] = numbers[i] || '';
            }

            // Focus last filled input or first empty one
            const lastIndex = Math.min(numbers.length - 1, digits - 1);
            if (lastIndex >= 0) {
                this.$refs[`input${lastIndex}`].focus();
            }
        }
    };
}
</script>
