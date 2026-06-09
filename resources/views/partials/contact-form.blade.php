@if(session('status'))
    <div class="alert alert--ok">{{ session('status') }}</div>
@endif

<form action="{{ route('contact.store') }}" method="POST" novalidate>
    @csrf

    <div class="field">
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required>
        @error('name') <p class="field-error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <p class="field-error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="organization">Organization</label>
        <input id="organization" type="text" name="organization" value="{{ old('organization') }}"
               placeholder="Fund, family office or company">
    </div>

    <div class="field">
        <label for="inquiry_type">I'm reaching out as</label>
        <select id="inquiry_type" name="inquiry_type">
            @foreach(['investor' => 'Investor / family office', 'partnership' => 'Partnership', 'talent' => 'Talent', 'general' => 'General'] as $val => $label)
                <option value="{{ $val }}" @selected(old('inquiry_type') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="message">Message</label>
        <textarea id="message" name="message" required>{{ old('message') }}</textarea>
        @error('message') <p class="field-error">{{ $message }}</p> @enderror
    </div>

    {{-- Honeypot: hidden from humans --}}
    <div style="position:absolute;left:-9999px" aria-hidden="true">
        <label>Company website</label>
        <input type="text" name="company_website" tabindex="-1" autocomplete="off">
    </div>

    <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center">
        Send message @include('partials.icon', ['name' => 'arrow'])
    </button>
</form>
