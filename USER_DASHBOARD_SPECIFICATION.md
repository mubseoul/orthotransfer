# User Dashboard Specification - OrthoTransfer Platform

## Overview

The OrthoTransfer platform manages **two distinct user types** with completely different needs and workflows. This document outlines how each user type interacts with their dashboard and what data they need to manage.

## User Types & Their Purposes

### **1. PATIENTS**

-   **Goal**: Find orthodontists to continue their treatment after moving/transferring
-   **Status**: Auto-approved upon registration
-   **Primary Need**: Search for doctors based on location, treatment type, and financial constraints

### **2. DOCTORS**

-   **Goal**: Offer orthodontic transfer services to patients
-   **Status**: Require admin approval before accessing full features
-   **Primary Need**: Manage practice information and receive patient inquiries

---

## Database Schema Understanding

### **Core User Table**

```sql
users (
    id, first_name, last_name, email, password,
    role ENUM('admin', 'patient', 'doctor'),
    is_approved BOOLEAN (true for patients, requires approval for doctors),
    approved_at, approved_by
)
```

### **Address Management (BOTH user types)**

```sql
user_addresses (
    user_id, label, address_line_1, address_line_2,
    city, state, postal_code, country,
    latitude, longitude, is_current BOOLEAN
)
```

-   **Purpose**: Location-based doctor searches and practice locations
-   **Constraint**: Only ONE address can be marked as "current" per user
-   **Usage**: GPS coordinates for distance calculations

---

## PATIENT WORKFLOW & DATA

### **Patient Profile Table**

```sql
patient_profiles (
    user_id,
    age,
    radius_willing_to_drive (in miles),
    moving_temporarily BOOLEAN,
    current_orthodontist_name,
    orthodontist_address,
    original_treatment_length_months,
    remaining_financial_amount,
    doctor_type_id (preferred doctor type)
)
```

### **Patient Many-to-Many Relationships**

1. **Treatments** (`patient_treatments`): Current braces/aligners they have
2. **Functional Appliances** (`patient_functional_appliances`): Herbst, Twin Block, etc.
3. **TADs** (`patient_tads`): Mini-implants, Mini-screws, etc.

### **Patient Dashboard Needs**

-   ✅ **Profile Management**: Complete detailed orthodontic history
-   ✅ **Address Management**: Current location for doctor searches
-   🔄 **Doctor Search**: Find nearby doctors based on:
    -   Current address + radius willing to drive
    -   Treatment compatibility (matching current treatments)
    -   Financial constraints (remaining budget vs doctor's minimum payment)
    -   Doctor type preference
-   🔄 **Inquiry Management**: Send inquiries to selected doctors
-   🔄 **Messages**: Communicate with interested doctors

---

## DOCTOR WORKFLOW & DATA

### **Doctor Profile Table**

```sql
doctor_profiles (
    user_id,
    title (Dr., DDS, DMD, etc.),
    phone_number,
    website,
    bio,
    minimum_monthly_payment
)
```

### **Doctor Many-to-Many Relationships**

1. **Transfer Types** (`doctor_transfer_types`): What types they accept
    - Complete Case Transfer, Finishing Only, Retention Only, etc.
2. **Insurance Providers** (`doctor_insurance_providers`): What insurance they accept
    - Aetna, Cigna, Delta Dental, etc.

### **Doctor Dashboard Needs**

-   ✅ **Profile Management**: Professional information and practice details
-   ✅ **Address Management**: Practice locations
-   🔄 **Inquiry Management**: View/respond to patient inquiries
-   🔄 **Patient Search**: Browse patients in their area (if they want to reach out)
-   🔄 **Messages**: Communicate with potential patients
-   🔄 **Availability Management**: Set availability for new patients

---

## ADMIN-MANAGED OPTIONS

All dropdown options are managed by admins and affect both user types:

### **For Patients**

-   **Doctor Types**: Orthodontist, General Dentist with Ortho Training, etc.
-   **Treatments**: Metal Braces, Ceramic Braces, Clear Aligners, etc.
-   **Functional Appliances**: Herbst, Twin Block, Forsus Springs, etc.
-   **TADs**: Mini-implants, Mini-plates, etc.

### **For Doctors**

-   **Transfer Types**: Complete Transfer, Finishing Only, Retention Only, etc.
-   **Insurance Providers**: Aetna, Cigna, Delta Dental, BCBS, etc.

---

## CURRENT IMPLEMENTATION STATUS

### ✅ **COMPLETED**

1. **User Authentication**: Role-based registration and login
2. **Dashboard Layout**: Frontend-integrated with sidebar navigation
3. **Profile Management**: Role-specific forms for both user types
4. **Address Management**: Add/edit/delete with current address logic
5. **Database Schema**: Complete with all relationships
6. **Admin Options**: Seeded with real orthodontic data

### 🔄 **NEXT PRIORITIES** (Based on User Needs)

#### **For Patients**

1. **Doctor Search Interface**:

    - Filter by location (current address + radius)
    - Filter by treatment compatibility
    - Filter by financial range
    - Filter by doctor type
    - Show distance from patient's current address

2. **Inquiry System**:
    - Send inquiries to selected doctors
    - Include patient's profile data automatically
    - Track inquiry status

#### **For Doctors**

1. **Inquiry Management**:

    - View patient inquiries with full patient profiles
    - Accept/decline inquiries
    - Set inquiry preferences

2. **Practice Management**:
    - Set availability status
    - Manage service areas
    - Set automated responses

---

## BUSINESS LOGIC RULES

### **Patient Rules**

-   Must have complete profile to search for doctors
-   Must have current address set
-   Can only search within their specified radius
-   Financial amount must be >= doctor's minimum payment

### **Doctor Rules**

-   Must be admin-approved to receive inquiries
-   Must have complete profile to appear in searches
-   Must have practice address (current address)
-   Must specify transfer types they accept

### **Matching Logic**

1. **Location**: Patient's current address + radius vs Doctor's practice location
2. **Treatment**: Patient's current treatments must be compatible with doctor's services
3. **Financial**: Patient's remaining budget >= Doctor's minimum payment
4. **Insurance**: Optional filter if patient has insurance doctor accepts

---

## DASHBOARD CUSTOMIZATION BY USER TYPE

### **Current Sidebar** (Same for Both)

-   Dashboard (overview/stats)
-   Profile (role-specific forms)
-   Addresses (location management)

### **Proposed Extended Sidebar**

#### **For Patients**

-   Dashboard
-   Profile ✅
-   Addresses ✅
-   **Find Doctors** (search interface)
-   **My Inquiries** (sent inquiries status)
-   **Messages** (doctor communications)

#### **For Doctors**

-   Dashboard
-   Profile ✅
-   Addresses ✅ (Practice Locations)
-   **Patient Inquiries** (incoming requests)
-   **Messages** (patient communications)
-   **Practice Settings** (availability, preferences)

---

## TECHNICAL ARCHITECTURE

### **Current Controllers**

-   `ProfileController`: ✅ Handles role-specific profile management
-   `AddressController`: ✅ Handles address CRUD with current address logic

### **Needed Controllers**

-   `DoctorSearchController`: Patient searches for doctors
-   `InquiryController`: Patient-doctor inquiry system
-   `MessageController`: Communication between users
-   `PracticeController`: Doctor practice management

### **Current Models & Relationships** ✅

All models are properly set up with correct relationships and the database schema supports the complete workflow.

---

This specification serves as the foundation for implementing the remaining features. The current dashboard framework (layout, forms, address management) is solid and ready for the next phase of development.
