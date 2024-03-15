<!-- Gender -->
<div class="space-y-2">
    <x-form.label for="gender" :value="__('Gender')" />

    <select id="gender" name="gender"
        class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
        <option value="male">{{ __('Male') }}</option>
        <option value="female">{{ __('Female') }}</option>
    </select>
</div>
