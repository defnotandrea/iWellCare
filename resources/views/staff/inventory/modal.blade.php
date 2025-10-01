<!-- Add Inventory Modal -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-green-600 to-green-700 text-white">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-plus text-white text-lg"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-lg font-bold" id="addInventoryModalLabel">Add Inventory Item</h5>
                        <p class="text-white/80 text-sm mb-0">Add a new item to the medical inventory</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addInventoryForm" action="{{ route('staff.inventory.store') }}" method="POST">
                @csrf
                <div class="modal-body p-6">
                    <!-- Basic Information Section -->
                    <div class="mb-6">
                        <h6 class="text-lg font-semibold mb-4 flex items-center gap-2" style="color: #166534;">
                            <i class="fas fa-info-circle" style="color: #059669;"></i>
                            Basic Information
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="modal_name" class="block text-sm font-medium mb-2" style="color: #374151;">Item Name <span style="color: #dc2626;">*</span></label>
                                <div class="relative">
                                    <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2" style="color: #9ca3af;"></i>
                                    <input type="text" id="modal_name" name="name" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="border: 2px solid #e5e7eb;" required>
                                </div>
                            </div>

                            <div>
                                <label for="modal_category" class="block text-sm font-medium mb-2" style="color: #374151;">Category <span style="color: #dc2626;">*</span></label>
                                <div class="relative">
                                    <i class="fas fa-list absolute left-3 top-1/2 transform -translate-y-1/2 z-10" style="color: #9ca3af;"></i>
                                    <select id="modal_category" name="category" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 appearance-none" style="border: 2px solid #e5e7eb;" required>
                                        <option value="">Select Category</option>
                                        <option value="medicine">Medicine</option>
                                        <option value="supplies">Medical Supplies</option>
                                        <option value="equipment">Equipment</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2" style="color: #9ca3af;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="modal_description" class="block text-sm font-medium mb-2" style="color: #374151;">Description</label>
                            <textarea id="modal_description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none" style="border: 2px solid #e5e7eb;" placeholder="Enter item description..."></textarea>
                        </div>
                    </div>

                    <!-- Quantity & Pricing Section -->
                    <div class="mb-6">
                        <h6 class="text-lg font-semibold mb-4 flex items-center gap-2" style="color: #166534;">
                            <i class="fas fa-calculator" style="color: #059669;"></i>
                            Quantity & Pricing
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="modal_quantity" class="block text-sm font-medium mb-2" style="color: #374151;">Quantity <span style="color: #dc2626;">*</span></label>
                                <div class="relative">
                                    <i class="fas fa-hashtag absolute left-3 top-1/2 transform -translate-y-1/2" style="color: #9ca3af;"></i>
                                    <input type="number" id="modal_quantity" name="quantity" min="0" step="1" value="0" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="border: 2px solid #e5e7eb;" required>
                                </div>
                            </div>

                            <div>
                                <label for="modal_unit_price" class="block text-sm font-medium mb-2" style="color: #374151;">Unit Price (₱) <span style="color: #dc2626;">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-sm font-medium" style="color: #059669;">₱</span>
                                    <input type="number" id="modal_unit_price" name="unit_price" min="0" step="0.01" class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="border: 2px solid #e5e7eb;" required>
                                </div>
                            </div>

                            <div>
                                <label for="modal_reorder_level" class="block text-sm font-medium mb-2" style="color: #374151;">Reorder Level</label>
                                <div class="relative">
                                    <i class="fas fa-exclamation-triangle absolute left-3 top-1/2 transform -translate-y-1/2" style="color: #9ca3af;"></i>
                                    <input type="number" id="modal_reorder_level" name="reorder_level" min="0" step="1" value="10" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="border: 2px solid #e5e7eb;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="mb-6">
                        <h6 class="text-lg font-semibold mb-4 flex items-center gap-2" style="color: #166534;">
                            <i class="fas fa-plus-circle" style="color: #059669;"></i>
                            Additional Information
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="modal_supplier" class="block text-sm font-medium mb-2" style="color: #374151;">Supplier</label>
                                <div class="relative">
                                    <i class="fas fa-truck absolute left-3 top-1/2 transform -translate-y-1/2" style="color: #9ca3af;"></i>
                                    <input type="text" id="modal_supplier" name="supplier" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="border: 2px solid #e5e7eb;" placeholder="Enter supplier name">
                                </div>
                            </div>

                            <div>
                                <label for="modal_expiration_date" class="block text-sm font-medium mb-2" style="color: #374151;">Expiration Date</label>
                                <div class="relative">
                                    <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2" style="color: #9ca3af;"></i>
                                    <input type="date" id="modal_expiration_date" name="expiration_date" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="border: 2px solid #e5e7eb;">
                                </div>
                            </div>

                            <div>
                                <label for="modal_location" class="block text-sm font-medium mb-2" style="color: #374151;">Storage Location</label>
                                <div class="relative">
                                    <i class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2" style="color: #9ca3af;"></i>
                                    <input type="text" id="modal_location" name="location" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="border: 2px solid #e5e7eb;" placeholder="e.g., Cabinet A, Shelf 2">
                                </div>
                            </div>

                            <div>
                                <label for="modal_batch_number" class="block text-sm font-medium mb-2" style="color: #374151;">Batch Number</label>
                                <div class="relative">
                                    <i class="fas fa-barcode absolute left-3 top-1/2 transform -translate-y-1/2" style="color: #9ca3af;"></i>
                                    <input type="text" id="modal_batch_number" name="batch_number" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="border: 2px solid #e5e7eb;" placeholder="Enter batch number">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="modal_notes" class="block text-sm font-medium mb-2" style="color: #374151;">Additional Notes</label>
                            <textarea id="modal_notes" name="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none" style="border: 2px solid #e5e7eb;" placeholder="Any additional notes or special instructions..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-t border-gray-200 flex justify-end gap-3 p-6">
                    <button type="button" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center gap-2" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </button>
                    <button type="submit" class="px-6 py-2 text-white rounded-lg transition-all flex items-center gap-2 transform hover:scale-105" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.1);">
                        <i class="fas fa-save"></i>
                        <span>Add Item</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>