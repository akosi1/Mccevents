<!-- User dashboard -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
            <!-- Events Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Events</h3>
                        <div class="flex items-center space-x-4">
                            <!-- Search Input -->
                            <div class="relative">
                                <input type="text" 
                                       id="searchEvents" 
                                       class="form-input rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-10 pr-4 py-2" 
                                       placeholder="Search events..." 
                                       style="width: 250px;">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- View Toggle Button -->
                            <button onclick="toggleView()" 
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg class="w-4 h-4 mr-2" id="viewIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                <span id="viewText">List View</span>
                            </button>
                        </div>
                    </div>

                    @if(isset($events) && $events->count() > 0)
                        <!-- Results Info -->
                        <div class="flex justify-between items-center mb-4">
                            <small class="text-gray-500">
                                Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} results
                            </small>
                            <small class="text-gray-500">
                                Page {{ $events->currentPage() }} of {{ $events->lastPage() }}
                            </small>
                        </div>

                        <!-- Card View - Default -->
                        <div id="cardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($events as $event)
                            <div class="event-card bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200" 
                                 data-search="{{ strtolower($event->title . ' ' . $event->location . ' ' . $event->description) }}">
                                <!-- Event Image -->
                                @if($event->hasImage())
                                <div class="aspect-w-16 aspect-h-9">
                                    <img src="{{ $event->image_url }}" 
                                         alt="{{ $event->title }}" 
                                         class="w-full h-48 object-cover rounded-t-lg cursor-pointer"
                                         onclick="showImage('{{ $event->image_url }}', '{{ $event->title }}')">
                                </div>
                                @else
                                <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif

                                <!-- Card Header -->
                                <div class="p-4 border-b border-gray-100">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->title }}</h4>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Event #{{ $event->id }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-4 space-y-3">
                                    <!-- Event Description (truncated) -->
                                    @if($event->description)
                                    <div class="text-sm text-gray-600">
                                        <p class="line-clamp-2">{{ Str::limit($event->description, 100) }}</p>
                                    </div>
                                    @endif

                                    <!-- Event Date -->
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-8 0h8a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $event->date->format('M d, Y') }}</span>
                                    </div>

                                    <!-- Event Location -->
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $event->location }}</span>
                                    </div>

                                    <!-- Created Date -->
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Created {{ $event->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                <!-- Card Footer with Actions -->
                                <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 rounded-b-lg">
                                    <div class="flex justify-center">
                                        <!-- View Button -->
                                        <button onclick="openEventModal({{ $event->id }})" 
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Table View - Hidden by default -->
                        <div id="tableView" class="hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($events as $event)
                                        <tr class="event-row hover:bg-gray-50" data-search="{{ strtolower($event->title . ' ' . $event->location . ' ' . $event->description) }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($event->hasImage())
                                                    <img src="{{ $event->image_url }}" alt="{{ $event->title }}" 
                                                         class="w-12 h-12 rounded-lg object-cover cursor-pointer"
                                                         onclick="showImage('{{ $event->image_url }}', '{{ $event->title }}')">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($event->description, 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event->date->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event->location }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $event->created_at->diffForHumans() }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="openEventModal({{ $event->id }})" 
                                                        class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="flex justify-between items-center mt-6">
                            <small class="text-gray-500">
                                Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} entries
                            </small>
                            <div class="flex-1 flex justify-center">
                                {{ $events->links() }}
                            </div>
                        </div>
                    @else
                        <!-- Empty State Card -->
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-8 0h8a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No events available</h3>
                            <p class="text-gray-500 mb-6">There are no events to display at the moment. Please check back later.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div id="eventModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-3 border-b">
                <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">Event Details</h3>
                <button onclick="closeEventModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="mt-4">
                <!-- Event Image -->
                <div id="modalImageContainer" class="mb-4 text-center hidden">
                    <img id="modalImage" src="" alt="" class="max-w-full max-h-64 mx-auto rounded shadow-sm">
                </div>
                
                <!-- Event Details -->
                <div class="space-y-3">
                    <div class="flex">
                        <span class="font-semibold text-gray-700 w-24">Date:</span>
                        <span id="modalDate" class="text-gray-900"></span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold text-gray-700 w-24">Location:</span>
                        <span id="modalLocation" class="text-gray-900"></span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold text-gray-700 w-24">Created:</span>
                        <span id="modalCreated" class="text-gray-900"></span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700">Description:</span>
                        <p id="modalDescription" class="text-gray-900 mt-1"></p>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end mt-6 pt-4 border-t">
                <button onclick="closeEventModal()" class="px-4 py-2 bg-gray-600 text-white text-sm rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 w-11/12 md:w-3/4 lg:w-1/2 text-center">
            <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="previewImage" src="" alt="" class="max-w-full max-h-screen mx-auto rounded shadow-lg">
            <p id="previewTitle" class="text-white mt-4 text-lg"></p>
        </div>
    </div>

    <script>
        // Event data for modal
        const events = @json($events->items());
        
        // Toggle between card and table view
        function toggleView() {
            const cardView = document.getElementById('cardView');
            const tableView = document.getElementById('tableView');
            const viewIcon = document.getElementById('viewIcon');
            const viewText = document.getElementById('viewText');
            
            if (cardView.classList.contains('hidden')) {
                // Show card view
                cardView.classList.remove('hidden');
                tableView.classList.add('hidden');
                viewIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>';
                viewText.textContent = 'List View';
            } else {
                // Show table view
                cardView.classList.add('hidden');
                tableView.classList.remove('hidden');
                viewIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>';
                viewText.textContent = 'Card View';
            }
        }
        
        // Search functionality
        document.getElementById('searchEvents').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const eventCards = document.querySelectorAll('.event-card');
            const eventRows = document.querySelectorAll('.event-row');
            
            // Filter cards
            eventCards.forEach(card => {
                const searchData = card.getAttribute('data-search');
                if (searchData.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Filter rows
            eventRows.forEach(row => {
                const searchData = row.getAttribute('data-search');
                if (searchData.includes(searchTerm)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Event modal functions
        function openEventModal(eventId) {
            const event = events.find(e => e.id === eventId);
            if (!event) return;
            
            // Populate modal content
            document.getElementById('modalTitle').textContent = event.title;
            document.getElementById('modalDate').textContent = new Date(event.date).toLocaleDateString();
            document.getElementById('modalLocation').textContent = event.location;
            document.getElementById('modalCreated').textContent = new Date(event.created_at).toLocaleDateString();
            document.getElementById('modalDescription').textContent = event.description || 'No description available';
            
            // Handle image
            const imageContainer = document.getElementById('modalImageContainer');
            const modalImage = document.getElementById('modalImage');
            
            if (event.image_url) {
                modalImage.src = event.image_url;
                modalImage.alt = event.title;
                imageContainer.classList.remove('hidden');
            } else {
                imageContainer.classList.add('hidden');
            }
            
            // Show modal
            document.getElementById('eventModal').classList.remove('hidden');
        }
        
        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }
        
        // Image preview functions
        function showImage(imageUrl, title) {
            document.getElementById('previewImage').src = imageUrl;
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
        }
        
        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
        
        // Close modals when clicking outside
        document.getElementById('eventModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEventModal();
            }
        });
        
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
        
        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEventModal();
                closeImageModal();
            }
        });
    </script>
</x-app-layout>