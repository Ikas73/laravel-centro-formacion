
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Institution Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your institution's profile information.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('settings.institution.update') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="institution_name" :value="__('Institution Name')" />
                                <x-text-input id="institution_name" name="institution_name" type="text" class="mt-1 block w-full" :value="old('institution_name', $settingsService->get('institution_name'))" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('institution_name')" />
                            </div>

                            <div>
                                <x-input-label for="institution_address" :value="__('Address')" />
                                <x-text-input id="institution_address" name="institution_address" type="text" class="mt-1 block w-full" :value="old('institution_address', $settingsService->get('institution_address'))" />
                                <x-input-error class="mt-2" :messages="$errors->get('institution_address')" />
                            </div>
                            
                            <div>
                                <x-input-label for="institution_phone" :value="__('Phone')" />
                                <x-text-input id="institution_phone" name="institution_phone" type="text" class="mt-1 block w-full" :value="old('institution_phone', $settingsService->get('institution_phone'))" />
                                <x-input-error class="mt-2" :messages="$errors->get('institution_phone')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'institution-settings-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>