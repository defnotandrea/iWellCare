@extends('layouts.admin')

@section('page-title', 'Staff Members')
@section('page-subtitle', '')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center">
                <div class="text-center">
                    <h2 class="text-xl font-semibold text-gray-900">Staff Members</h2>
                    <p class="text-sm text-gray-600">Manage your staff members and their access</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Team Members</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $staff->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-check text-2xl text-green-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Members</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $staff->where('is_active', true)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-times text-2xl text-red-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Inactive Members</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $staff->where('is_active', false)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-plus text-2xl text-purple-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">This Month</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $staff->where('created_at', '>=', now()->startOfMonth())->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Members Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Team Members</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">A list of all team members in your organization.</p>
            </div>
            
            @if($staff->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($staff as $member)
                    <li>
                        <div class="px-4 py-4 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="flex items-center">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </p>
                                        @if($member->is_active)
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-1">
                                        <p class="text-sm text-gray-500">{{ $member->email }}</p>
                                        <p class="text-sm text-gray-500">{{ $member->username }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.staff.show', $member) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    View
                                </a>
                                <a href="{{ route('admin.staff.edit', $member) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.staff.toggle-status', $member) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-{{ $member->is_active ? 'red' : 'green' }}-600 hover:text-{{ $member->is_active ? 'red' : 'green' }}-900 text-sm font-medium">
                                        {{ $member->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.staff.destroy', $member) }}" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-900 text-sm font-medium btn-open-delete-modal">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                
                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $staff->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No team members</h3>
                    <p class="text-gray-500 mb-6">Get started by adding your first team member.</p>
                    <a href="{{ route('admin.staff.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-2"></i>
                        Add Team Member
                    </a>
                </div>
            @endif
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="confirmDeleteModal" class="fixed inset-0 z-50 hidden">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Confirm Deletion</h3>
                        <p class="text-sm text-gray-600 mt-1">Are you sure you want to delete this team member?</p>
                    </div>
                    <div class="px-6 py-5 flex items-center justify-end space-x-3">
                        <button type="button" id="btnCancelDelete" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">Cancel</button>
                        <button type="button" id="btnConfirmDelete" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function() {
        let pendingForm = null;
        const modal = document.getElementById('confirmDeleteModal');
        const btnCancel = document.getElementById('btnCancelDelete');
        const btnConfirm = document.getElementById('btnConfirmDelete');

        function openModal(form) {
            pendingForm = form;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
            pendingForm = null;
        }

        document.querySelectorAll('.btn-open-delete-modal').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const form = this.closest('form.delete-form');
                if (form) {
                    openModal(form);
                }
            });
        });

        btnCancel.addEventListener('click', closeModal);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
        btnConfirm.addEventListener('click', function() {
            if (pendingForm) {
                pendingForm.submit();
            }
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    })();
</script>
@endpush
