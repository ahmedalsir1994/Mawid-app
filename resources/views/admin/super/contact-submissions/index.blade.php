<x-admin-layout>
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">Contact Submissions</h1>
            <p class="text-gray-500 mt-1 text-sm">Messages submitted through the public contact form</p>
        </div>
        @if($unreadCount > 0)
            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-green-50 border border-green-200 text-green-700 text-sm font-bold">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                {{ $unreadCount }} unread
            </span>
        @endif
    </div>

    <!-- Flash -->
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <form method="GET" class="mb-6 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Name, email, phone, subject…"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Status</label>
            <select name="status"
                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                <option value="">All</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                <option value="read"   {{ request('status') === 'read'   ? 'selected' : '' }}>Read</option>
            </select>
        </div>
        <button type="submit"
            class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition">
            Filter
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.contact-submissions.index') }}"
               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition">
                Clear
            </a>
        @endif
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($submissions as $submission)
                <div class="p-4 {{ $submission->is_read ? '' : 'bg-green-50/40' }} hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $submission->name }}</p>
                            <a href="mailto:{{ $submission->email }}" class="text-xs text-green-700 hover:underline block">{{ $submission->email }}</a>
                            <a href="tel:{{ $submission->phone }}" class="text-xs text-gray-500 block">{{ $submission->phone }}</a>
                        </div>
                        @if($submission->is_read)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 text-xs font-medium shrink-0">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Read
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-bold shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                New
                            </span>
                        @endif
                    </div>
                    @if($submission->subject)
                        <p class="text-xs font-medium text-gray-700 truncate mb-1">{{ $submission->subject }}</p>
                    @endif
                    <p class="text-xs text-gray-400 truncate mb-2">{{ \Illuminate\Support\Str::limit($submission->message, 80) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">{{ $submission->created_at->format('d M Y, H:i') }}</span>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.contact-submissions.show', $submission) }}"
                               class="px-2.5 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition">View</a>
                            <form method="POST"
                                  action="{{ $submission->is_read ? route('admin.contact-submissions.mark-unread', $submission) : route('admin.contact-submissions.mark-read', $submission) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-lg transition">
                                    {{ $submission->is_read ? 'Unread' : 'Mark Read' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.contact-submissions.destroy', $submission) }}" onsubmit="return confirm('Delete this submission?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg transition">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-5 py-16 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    No contact submissions found.
                </div>
            @endforelse
        </div>
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Name</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Contact</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Subject</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Received</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($submissions as $submission)
                        <tr class="{{ $submission->is_read ? 'bg-white' : 'bg-green-50/40' }} hover:bg-gray-50 transition">
                            <td class="px-5 py-4">
                                @if($submission->is_read)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-100 text-gray-500 text-xs font-medium">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Read
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                        New
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-900">{{ $submission->name }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <a href="mailto:{{ $submission->email }}" class="block text-green-700 hover:underline text-xs">{{ $submission->email }}</a>
                                <a href="tel:{{ $submission->phone }}" class="block text-gray-500 text-xs mt-0.5">{{ $submission->phone }}</a>
                            </td>
                            <td class="px-5 py-4 max-w-[180px]">
                                <p class="text-gray-700 truncate">{{ $submission->subject ?: '—' }}</p>
                                <p class="text-xs text-gray-400 truncate mt-0.5">{{ \Illuminate\Support\Str::limit($submission->message, 60) }}</p>
                            </td>
                            <td class="px-5 py-4 text-gray-500 whitespace-nowrap text-xs">
                                {{ $submission->created_at->format('d M Y') }}<br>
                                {{ $submission->created_at->format('H:i') }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.contact-submissions.show', $submission) }}"
                                       class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition">
                                        View
                                    </a>
                                    <form method="POST"
                                          action="{{ $submission->is_read ? route('admin.contact-submissions.mark-unread', $submission) : route('admin.contact-submissions.mark-read', $submission) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-lg transition">
                                            {{ $submission->is_read ? 'Unread' : 'Mark Read' }}
                                        </button>
                                    </form>
                                    <form method="POST"
                                          action="{{ route('admin.contact-submissions.destroy', $submission) }}"
                                          onsubmit="return confirm('Delete this submission?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                No contact submissions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- end desktop table -->

        @if($submissions->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
