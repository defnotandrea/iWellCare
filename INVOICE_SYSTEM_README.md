# Invoice System Implementation

This document describes the invoice system that has been implemented based on the Adult Wellness Clinic service invoice layout.

## Overview

The invoice system consists of:
1. **Invoice Layout Component** - A reusable Blade component that displays invoices
2. **Invoice Controller** - Handles invoice CRUD operations
3. **Invoice Creation Form** - A form for creating new invoices
4. **Demo Page** - Shows how to use the invoice component

## Files Created

### 1. Invoice Layout Component
- **Location**: `resources/views/components/invoice-layout.blade.php`
- **Purpose**: Reusable component that displays invoices with the exact layout from the Adult Wellness Clinic form
- **Features**:
  - Carbon copy overlay effect
  - Responsive design with Tailwind CSS
  - Interactive payment method selection
  - Automatic calculations
  - Print-friendly styling

### 2. Invoice Controller
- **Location**: `app/Http/Controllers/InvoiceController.php`
- **Purpose**: Handles all invoice-related operations
- **Methods**:
  - `create()` - Show invoice creation form
  - `store()` - Save new invoice
  - `show()` - Display invoice
  - `edit()` - Show edit form
  - `update()` - Update invoice
  - `destroy()` - Delete invoice
  - `generatePdf()` - Generate PDF version
  - `downloadPdf()` - Download PDF

### 3. Invoice Creation Form
- **Location**: `resources/views/invoices/create.blade.php`
- **Purpose**: Form for creating new invoices
- **Features**:
  - Dynamic item addition/removal
  - Real-time calculations
  - Form validation
  - Preview functionality

### 4. Demo Page
- **Location**: `resources/views/demo/invoice-demo.blade.php`
- **Purpose**: Demonstrates the invoice component with sample data
- **Route**: `/invoice-demo`

## Usage

### Basic Invoice Display

```blade
<x-invoice-layout 
    invoiceNumber="0001635"
    date="December 15, 2024"
    customerName="Customer Name"
    customerTin="123-456-789-000"
    customerAddress="Customer Address"
    customerId="ID-Number"
    customerSignature="Customer Signature"
    totalSales="1000.00"
    discount="100.00"
    totalDue="900.00"
    withholding="0.00"
    totalAmountDue="900.00"
    exemptSales="0.00"
    paymentMethod="cash"
    cashierName="Cashier Name"
/>
```

### Available Props

| Prop | Type | Description | Default |
|------|------|-------------|---------|
| `invoiceNumber` | string | Invoice number | '0001635' |
| `date` | string | Invoice date | Current date |
| `customerName` | string | Customer's full name | '' |
| `customerTin` | string | Tax Identification Number | '' |
| `customerAddress` | string | Customer's address | '' |
| `customerId` | string | SC/PWD/PNSTM/Solo Parent ID | '' |
| `customerSignature` | string | Customer signature/name | '' |
| `totalSales` | string | Total sales amount | '' |
| `discount` | string | Discount amount | '' |
| `totalDue` | string | Total due after discount | '' |
| `withholding` | string | Withholding amount | '' |
| `totalAmountDue` | string | Final amount due | '' |
| `exemptSales` | string | Exempt sales amount | '' |
| `paymentMethod` | string | cash, check, or credit | 'cash' |
| `checkNumber` | string | Check number (if check payment) | '' |
| `checkDate` | string | Check date (if check payment) | '' |
| `bank` | string | Bank name (if check payment) | '' |
| `cashierName` | string | Cashier or authorized representative | '' |

## Routes

The following routes are available for invoice management:

```php
// Invoice routes
Route::prefix('invoices')->name('invoices.')->group(function () {
    Route::get('/create', [InvoiceController::class, 'create'])->name('create');
    Route::post('/', [InvoiceController::class, 'store'])->name('store');
    Route::get('/{id}', [InvoiceController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('edit');
    Route::put('/{id}', [InvoiceController::class, 'update'])->name('update');
    Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/generate-pdf', [InvoiceController::class, 'generatePdf'])->name('generate-pdf');
    Route::get('/{id}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('download-pdf');
});
```

## Features

### 1. Carbon Copy Effect
- Yellow overlay in top-left corner
- Rotated appearance for authenticity
- Hidden during printing

### 2. Interactive Elements
- Payment method selection (Cash/Check/Credit)
- Dynamic check details form
- Real-time calculations

### 3. Automatic Calculations
- Row totals (quantity × unit cost)
- Total sales calculation
- Discount and withholding adjustments
- Final amount due

### 4. Responsive Design
- Mobile-friendly layout
- Tailwind CSS styling
- Print-optimized CSS

### 5. Form Validation
- Required field validation
- Numeric input validation
- Conditional validation for check payments

## Customization

### Clinic Information
To customize the clinic information, edit the header section in `invoice-layout.blade.php`:

```blade
<h1 class="text-2xl font-bold text-gray-800 mb-2">YOUR CLINIC NAME</h1>
<p class="text-sm text-gray-600 mb-1">Your Clinic Address</p>
<p class="text-sm text-gray-600 mb-1">Your Proprietor Name - Prop.</p>
<p class="text-sm text-gray-600 mb-3">Your Tax Information</p>
```

### Colors and Styling
Modify the CSS variables and Tailwind classes in the component to match your brand colors.

### PTU Details
Update the bottom section with your clinic's PTU information:

```blade
<div class="grid grid-cols-4 gap-4 text-center mt-2">
    <div>
        <span class="font-semibold">SERIAL NO. FROM:</span><br>
        <span>YOUR_SERIAL_FROM</span>
    </div>
    <!-- ... other fields ... -->
</div>
```

## Database Integration

To fully integrate with a database, you'll need to:

1. **Create Invoice Model**:
```bash
php artisan make:model Invoice -m
```

2. **Create Invoice Items Model**:
```bash
php artisan make:model InvoiceItem -m
```

3. **Update Controller Methods** to use Eloquent models instead of mock data

4. **Add Validation Rules** for database constraints

## PDF Generation

For PDF generation, consider using:
- **DomPDF** (already included in Laravel)
- **Snappy PDF** (for better rendering)
- **jsPDF** (client-side generation)

Example with DomPDF:
```php
use Barryvdh\DomPDF\Facade\Pdf;

public function generatePdf(string $id)
{
    $invoice = Invoice::findOrFail($id);
    $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
    return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
}
```

## Security Considerations

1. **CSRF Protection**: All forms include CSRF tokens
2. **Input Validation**: Comprehensive validation rules
3. **Authorization**: Add middleware for role-based access
4. **Data Sanitization**: Proper escaping of user input

## Browser Compatibility

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile responsive
- Print-friendly
- JavaScript required for interactive features

## Future Enhancements

1. **Email Integration**: Send invoices via email
2. **Digital Signatures**: Electronic signature support
3. **Multi-language Support**: Internationalization
4. **Template System**: Multiple invoice templates
5. **Bulk Operations**: Mass invoice generation
6. **Reporting**: Invoice analytics and reports
7. **Integration**: Connect with accounting software

## Troubleshooting

### Common Issues

1. **Component Not Found**: Ensure the component is in the correct directory
2. **Styling Issues**: Check if Tailwind CSS is properly loaded
3. **JavaScript Errors**: Verify browser console for errors
4. **Print Issues**: Use print-specific CSS media queries

### Debug Mode

Enable debug mode in `.env`:
```
APP_DEBUG=true
```

## Support

For issues or questions:
1. Check the Laravel logs in `storage/logs/`
2. Verify all routes are properly registered
3. Ensure all required files are in place
4. Check browser console for JavaScript errors

## License

This invoice system is part of the iWellCare application and follows the same licensing terms.
