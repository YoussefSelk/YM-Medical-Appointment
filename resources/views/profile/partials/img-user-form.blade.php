<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your profile picture.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.img') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        <div class="space-y-2">
            <label for="img"
                class="cursor-pointer flex items-center justify-center w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-md border border-gray-300 hover:bg-gray-300 focus:bg-gray-300 transition duration-200 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span id="file-name">{{ __('Choose a file') }}</span>
                <input id="img" name="img" type="file" class="hidden" required accept="image/*">
            </label>

            <img id="preview-img" class="hidden rounded-md mx-auto mt-2" alt="Preview Image">

            <x-form.error :messages="$errors->get('img')" />
        </div>

        <div class="flex items-center gap-4">
            <x-button>
                <span class="mr-2"><i class="fa-regular fa-floppy-disk" style="color: #ffffff;"></i></span>{{ __('Save') }}
            </x-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Profile picture updated.') }}
                </p>
            @endif
        </div>
    </form>

    <form action="{{route('profile.img.delete')}}" method="POST">
        @csrf
        @method('delete')
        <x-button variant="danger">
            <span class="mr-2"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></span>  {{ __('Delete Picture') }}
          </x-button>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('img');
        const fileNameDisplay = document.getElementById('file-name');
        const imgPreview = document.getElementById('preview-img');

        input.addEventListener('change', function() {
            if (input.files.length > 0) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('hidden');
                }

                reader.readAsDataURL(file);
                fileNameDisplay.textContent = file.name;
            } else {
                fileNameDisplay.textContent = "{{ __('Choose a file') }}";
                imgPreview.classList.add('hidden');
                imgPreview.src = '';
            }
        });
    });
</script>
