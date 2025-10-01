# New Account Registration Guide - iWellCare

## 🎯 **How to Create a New Account**

### **Step 1: Go to Registration Page**
- **URL:** http://127.0.0.1:8000/register
- This will show the patient registration form

### **Step 2: Fill Out the Registration Form**

#### **Personal Information:**
- **First Name:** Your first name
- **Last Name:** Your last name
- **Username:** Choose a unique username (4-20 characters, letters, numbers, underscores only)
- **Email:** Your email address (this is where you'll receive the verification code)

#### **Contact Information:**
- **Phone Number:** Your contact number
- **Street Address:** Your complete address
- **City:** Your city
- **State/Province:** Your state or province
- **Postal Code:** Your postal code (optional)

#### **Personal Details:**
- **Date of Birth:** Your birth date
- **Gender:** Select your gender
- **Blood Type:** Your blood type (optional)

#### **Security:**
- **Password:** Create a strong password (minimum 10 characters)
  - Must contain: uppercase, lowercase, number, special character
- **Confirm Password:** Re-enter your password

### **Step 3: Submit Registration**
- Click **"Register"** button
- The system will validate your information
- If successful, you'll be redirected to email verification

### **Step 4: Email Verification**
- You'll be automatically redirected to: http://127.0.0.1:8000/verify-email
- **Check your email** for the verification code
- **Enter the 6-digit code** in the verification form
- Click **"Verify Email"**

### **Step 5: Access Your Account**
- After verification, you'll be redirected to your dashboard
- You can now log in with your username and password

## 🔧 **Troubleshooting**

### **If You Don't Receive the Email:**
1. **Check Spam/Junk folder**
2. **Check Promotions tab** (if using Gmail)
3. **Wait a few minutes** for email delivery
4. **Click "Resend Code"** on the verification page

### **If the Verification Page is Empty:**
1. **Refresh the page** (Ctrl + F5)
2. **Make sure you're logged in**
3. **Check the browser console** for errors

### **If Registration Fails:**
- **Check all required fields** are filled
- **Ensure username is unique**
- **Verify email is valid and unique**
- **Make sure password meets requirements**

## 📧 **Email Verification Process**

### **What Happens After Registration:**
1. ✅ **Account created** in the database
2. ✅ **Patient record created** automatically
3. ✅ **OTP code generated** and sent to your email
4. ✅ **Redirected to verification page**
5. ✅ **Email verification required** before accessing dashboard

### **OTP Code Details:**
- **Format:** 6-digit numeric code
- **Expiration:** 10 minutes
- **Usage:** Single-use only
- **Resend:** Available after 60 seconds

## 🛡️ **Security Features**

### **Password Requirements:**
- Minimum 10 characters
- At least 1 uppercase letter
- At least 1 lowercase letter
- At least 1 number
- At least 1 special character (@$!%*?&)
- No common patterns
- No more than 2 consecutive identical characters

### **Username Requirements:**
- 4-20 characters
- Letters, numbers, and underscores only
- Must be unique
- Cannot be a reserved word

## 📱 **After Registration**

### **Your Account Features:**
- ✅ **Patient Dashboard** with appointment booking
- ✅ **Medical Records** management
- ✅ **Prescription History** viewing
- ✅ **Consultation History** access
- ✅ **Profile Management**

### **Next Steps:**
1. **Complete your profile** with additional information
2. **Book your first appointment**
3. **Upload any medical documents**
4. **Set up emergency contacts**

## 🆘 **Need Help?**

### **If You Encounter Issues:**
1. **Check the browser console** for error messages
2. **Try a different browser**
3. **Clear browser cache** and cookies
4. **Contact support** if problems persist

### **Common Issues:**
- **"Username already taken"** - Choose a different username
- **"Email already registered"** - Use a different email or try logging in
- **"Password too weak"** - Follow the password requirements
- **"Invalid email format"** - Check your email address

---

**Registration URL:** http://127.0.0.1:8000/register
**Verification URL:** http://127.0.0.1:8000/verify-email 