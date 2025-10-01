# iWellCare ERD for Draw.io (diagrams.net)

This repository contains Entity Relationship Diagrams for the iWellCare Healthcare Management System in Draw.io compatible format.

## Files

1. **`iWellCare_ERD_DrawIO.xml`** - Complete ERD with all attributes and detailed relationships
2. **`iWellCare_ERD_DrawIO_Simple.xml`** - Simplified ERD focusing on core entities and relationships
3. **`DRAWIO_ERD_README.md`** - This documentation file

## How to Open in Draw.io

### Option 1: Online (Recommended)
1. Go to [draw.io](https://app.diagrams.net/) or [diagrams.net](https://diagrams.net/)
2. Click "Open Existing Diagram"
3. Choose "Device" and select one of the `.xml` files
4. The diagram will open with all tables and relationships

### Option 2: Desktop App
1. Download [Draw.io Desktop](https://github.com/jgraph/drawio-desktop/releases)
2. Install and open the application
3. Go to File → Open and select the `.xml` file

### Option 3: VS Code Extension
1. Install the "Draw.io Integration" extension in VS Code
2. Right-click on any `.xml` file
3. Select "Open With Draw.io Integration"

## ERD Features

### 🎨 **Visual Design**
- **Color-coded tables** for easy identification
- **Clear relationships** with cardinality indicators
- **Professional layout** optimized for readability
- **Legend and notes** for better understanding

### 📊 **Table Information**
- **Primary Keys** shown in **bold**
- **Foreign Keys** shown in *italic*
- **Data types** clearly specified
- **Essential fields** highlighted

### 🔗 **Relationship Types**
- **1:1** = One-to-One relationships
- **1:N** = One-to-Many relationships
- **N:M** = Many-to-Many relationships

## System Architecture

### **Core Entities (Top Row)**
- **users** (Red) - Central user management
- **patients** (Blue) - Patient demographics
- **doctors** (Green) - Doctor profiles
- **appointments** (Orange) - Scheduling system
- **inventory** (Light Blue) - Medical supplies

### **Supporting Entities (Bottom Row)**
- **consultations** (Purple) - Medical consultations
- **medical_records** (Pink) - Patient records
- **prescriptions** (Cyan) - Medication prescriptions
- **billings** (Yellow) - Financial management
- **otp_codes** (Light Orange) - Security verification

## Key Relationships

### **User Management Flow**
```
users (1:1) → patients
users (1:1) → doctors
users (1:N) → otp_codes
users (1:N) → inventory
```

### **Patient Care Flow**
```
patients (1:N) → appointments
appointments (1:1) → consultations
consultations (1:1) → medical_records
consultations (1:1) → prescriptions
appointments (1:1) → billings
```

### **Doctor Operations**
```
doctors (1:N) → appointments
doctors (1:N) → consultations
doctors (1:N) → medical_records
doctors (1:N) → prescriptions
```

## Customization Options

### **Modifying the Diagram**
1. **Add new tables** - Right-click and add new shapes
2. **Modify relationships** - Drag connection points
3. **Change colors** - Select table and modify fill color
4. **Add fields** - Edit table text content
5. **Rearrange layout** - Drag tables to new positions

### **Export Options**
- **PNG/JPEG** - For presentations and documents
- **PDF** - For printing and sharing
- **SVG** - For web use and further editing
- **XML** - For backup and version control

## Best Practices

### **When Working with the ERD**
1. **Save frequently** - Draw.io auto-saves but manual saves are recommended
2. **Use layers** - Organize complex diagrams with layers
3. **Add comments** - Use text boxes for additional explanations
4. **Version control** - Save different versions for different purposes

### **For Presentations**
1. **Use simplified version** - `iWellCare_ERD_DrawIO_Simple.xml`
2. **Export as PNG** - High resolution for slides
3. **Focus on relationships** - Highlight key data flows
4. **Add annotations** - Explain complex relationships

## Troubleshooting

### **Common Issues**
- **File won't open** - Ensure you're using a compatible Draw.io version
- **Missing tables** - Check if all XML content was copied correctly
- **Relationship lines broken** - Try refreshing the page or reopening
- **Text formatting issues** - Use the text editor in Draw.io to fix

### **Getting Help**
- **Draw.io Documentation** - [https://drawio-app.com/docs/](https://drawio-app.com/docs/)
- **Community Support** - [https://github.com/jgraph/drawio](https://github.com/jgraph/drawio)
- **Online Help** - Use the Help menu in Draw.io

## Integration with Other Tools

### **Laravel Development**
- Use this ERD alongside your database migrations
- Reference for model relationships
- Guide for API endpoint design

### **Documentation**
- Include in project documentation
- Use for stakeholder presentations
- Reference for database administrators

### **Team Collaboration**
- Share via Draw.io cloud storage
- Export for team meetings
- Use for code reviews

## File Structure

```
iWellCare_ERD_DrawIO.xml          # Complete ERD
iWellCare_ERD_DrawIO_Simple.xml   # Simplified ERD
DRAWIO_ERD_README.md              # This file
DATA_DICTIONARY.md                # Field definitions
iWellCare_ERD.puml               # PlantUML version
iWellCare_ERD_Simplified.puml    # PlantUML simplified
```

## Support

For questions about the ERD or database design:
- Check the `DATA_DICTIONARY.md` for field details
- Review database migration files
- Examine model files in `app/Models/`
- Use the PlantUML versions as alternatives

---

**Note**: These Draw.io files are optimized for the latest version of Draw.io. For best results, use the online version at [app.diagrams.net](https://app.diagrams.net/).
