# Orthodontic Transfer Platform - Database Schema Documentation

## Overview

This document outlines the complete database schema for the Orthodontic Transfer Platform, a system that connects patients seeking orthodontic treatment transfers with qualified doctors.

## System Architecture

The platform supports three main user types:

-   **Admins**: Platform administrators with full management capabilities
-   **Patients**: Users seeking orthodontic treatment transfers
-   **Doctors**: Orthodontic practitioners offering transfer services

## Core Tables

### 1. Users Table

**Primary user authentication and basic information**

| Column            | Type            | Description                         |
| ----------------- | --------------- | ----------------------------------- |
| id                | bigint          | Primary key                         |
| first_name        | string          | User's first name                   |
| last_name         | string          | User's last name                    |
| email             | string (unique) | User's email address                |
| email_verified_at | timestamp       | Email verification timestamp        |
| password          | string (hashed) | User's password                     |
| role              | enum            | User role: admin, patient, doctor   |
| is_approved       | boolean         | Approval status (for doctors)       |
| approved_at       | timestamp       | Approval timestamp                  |
| approved_by       | bigint (FK)     | Admin who approved the user         |
| remember_token    | string          | Remember token for "stay logged in" |
| created_at        | timestamp       | Record creation time                |
| updated_at        | timestamp       | Record last update time             |

**Key Features:**

-   Self-referencing foreign key for admin approval tracking
-   Role-based access control
-   Automatic approval for patients and admins
-   Doctor approval workflow

### 2. User Addresses Table

**Multiple addresses per user with current address tracking**

| Column         | Type          | Description                      |
| -------------- | ------------- | -------------------------------- |
| id             | bigint        | Primary key                      |
| user_id        | bigint (FK)   | Reference to users table         |
| label          | string        | Address label (Home, Work, etc.) |
| address_line_1 | string        | Primary address line             |
| address_line_2 | string        | Secondary address line           |
| city           | string        | City name                        |
| state          | string        | State/Province                   |
| postal_code    | string        | ZIP/Postal code                  |
| country        | string        | Country name                     |
| latitude       | decimal(10,8) | GPS latitude                     |
| longitude      | decimal(11,8) | GPS longitude                    |
| is_current     | boolean       | Current address flag             |
| created_at     | timestamp     | Record creation time             |
| updated_at     | timestamp     | Record last update time          |

**Key Features:**

-   Supports multiple addresses per user
-   Only one current address per user
-   GPS coordinates for location-based searches
-   Optimized indexes for location queries

## Profile Tables

### 3. Patient Profiles Table

**Detailed orthodontic information for patients**

| Column                           | Type          | Description                      |
| -------------------------------- | ------------- | -------------------------------- |
| id                               | bigint        | Primary key                      |
| user_id                          | bigint (FK)   | Reference to users table         |
| age                              | integer       | Patient's age                    |
| radius_willing_to_drive          | integer       | Maximum driving distance (miles) |
| moving_temporarily               | boolean       | Temporary relocation status      |
| current_orthodontist_name        | string        | Current orthodontist name        |
| orthodontist_address             | text          | Current orthodontist address     |
| original_treatment_length_months | integer       | Original treatment duration      |
| remaining_financial_amount       | decimal(10,2) | Remaining balance (USD)          |
| doctor_type_id                   | bigint (FK)   | Preferred doctor type            |
| created_at                       | timestamp     | Record creation time             |
| updated_at                       | timestamp     | Record last update time          |

### 4. Doctor Profiles Table

**Professional information for doctors**

| Column                  | Type          | Description                        |
| ----------------------- | ------------- | ---------------------------------- |
| id                      | bigint        | Primary key                        |
| user_id                 | bigint (FK)   | Reference to users table           |
| title                   | string        | Professional title (Dr., MD, etc.) |
| phone_number            | string        | Contact phone number               |
| website                 | string        | Professional website               |
| bio                     | text          | Professional biography             |
| minimum_monthly_payment | decimal(10,2) | Minimum payment accepted           |
| created_at              | timestamp     | Record creation time               |
| updated_at              | timestamp     | Record last update time            |

## Admin-Managed Option Tables

These tables store options that can be managed by administrators:

### 5. Treatments Table

**Available orthodontic treatments**

Examples: Traditional Metal Braces, Ceramic Braces, Clear Aligners, etc.

### 6. Functional Appliances Table

**Orthodontic functional appliances**

Examples: Herbst Appliance, Twin Block, Forsus Springs, etc.

### 7. TADs Table

**Temporary Anchorage Devices**

Examples: Mini-implants, Mini-plates, Orthodontic Mini-screws, etc.

### 8. Doctor Types Table

**Types of orthodontic practitioners**

Examples: Orthodontist, General Dentist with Orthodontic Training, etc.

### 9. Transfer Types Table

**Types of treatment transfers offered by doctors**

Examples: Complete Case Transfer, Finishing Only, Retention Only, etc.

### 10. Insurance Providers Table

**Accepted insurance providers**

Examples: Aetna, Cigna, Delta Dental, Blue Cross Blue Shield, etc.

**Common Structure for Option Tables:**
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Option name |
| description | text | Option description |
| is_active | boolean | Active status |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record last update time |

## Relationship Tables (Many-to-Many)

### Patient Relationship Tables

#### 11. Patient Treatments Table

Links patients to their current treatments

#### 12. Patient Functional Appliances Table

Links patients to their functional appliances

#### 13. Patient TADs Table

Links patients to their TADs

### Doctor Relationship Tables

#### 14. Doctor Transfer Types Table

Links doctors to the transfer types they offer

#### 15. Doctor Insurance Providers Table

Links doctors to the insurance providers they accept

**Common Structure for Relationship Tables:**
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| [profile]\_id | bigint (FK) | Reference to profile table |
| [option]\_id | bigint (FK) | Reference to option table |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record last update time |

## Key Relationships

### User Relationships

-   **One-to-Many**: User → Addresses
-   **One-to-One**: User → Patient Profile
-   **One-to-One**: User → Doctor Profile
-   **Self-Referencing**: User → User (approval tracking)

### Profile Relationships

-   **Many-to-One**: Patient Profile → Doctor Type
-   **Many-to-Many**: Patient Profile ↔ Treatments
-   **Many-to-Many**: Patient Profile ↔ Functional Appliances
-   **Many-to-Many**: Patient Profile ↔ TADs
-   **Many-to-Many**: Doctor Profile ↔ Transfer Types
-   **Many-to-Many**: Doctor Profile ↔ Insurance Providers

## Indexes and Performance

### Optimized Indexes

-   **Location-based queries**: `(latitude, longitude)` on user_addresses
-   **Current address lookup**: `(user_id, is_current)` on user_addresses
-   **Role-based queries**: `role` on users
-   **Approval status**: `is_approved` on users
-   **Active options**: `is_active` on all option tables

### Unique Constraints

-   **User email**: Ensures unique email addresses
-   **Relationship pairs**: Prevents duplicate relationships in junction tables
-   **Current address**: Business logic ensures only one current address per user

## Data Integrity

### Foreign Key Constraints

-   **Cascade deletes**: User deletion removes all associated data
-   **Set null**: Option deletion sets references to null
-   **Restrict deletes**: Prevents deletion of referenced admin options

### Validation Rules

-   **Email uniqueness**: Enforced at database level
-   **Role validation**: Enum constraint on user roles
-   **Boolean constraints**: Proper boolean handling for flags
-   **Decimal precision**: Financial amounts with 2 decimal places

## Security Considerations

### Data Protection

-   **Password hashing**: All passwords stored using Laravel's Hash facade
-   **Soft deletes**: Consider implementing for audit trails
-   **Data encryption**: Sensitive fields can be encrypted at application level

### Access Control

-   **Role-based permissions**: Enforced at application level
-   **Approval workflow**: Doctors require admin approval
-   **Data isolation**: Users can only access their own data

## Usage Examples

### Common Queries

```sql
-- Find all approved doctors within 50 miles of a location
SELECT u.*, dp.* FROM users u
JOIN doctor_profiles dp ON u.id = dp.user_id
JOIN user_addresses ua ON u.id = ua.user_id
WHERE u.role = 'doctor'
  AND u.is_approved = true
  AND ua.is_current = true
  AND ST_Distance_Sphere(
    POINT(ua.longitude, ua.latitude),
    POINT(?, ?)
  ) <= 50 * 1609.34;

-- Get patient's complete profile with all relationships
SELECT p.*, dt.name as doctor_type
FROM patient_profiles p
LEFT JOIN doctor_types dt ON p.doctor_type_id = dt.id
WHERE p.user_id = ?;
```

## Migration Order

1. Update users table
2. Create admin option tables
3. Create address table
4. Create profile tables
5. Create relationship tables

This order ensures all foreign key dependencies are satisfied.

## Future Considerations

### Potential Enhancements

-   **Messaging system**: Patient-doctor communication
-   **Appointment scheduling**: Consultation booking
-   **File attachments**: X-rays, treatment records
-   **Payment processing**: Integrated payment system
-   **Reviews and ratings**: Doctor rating system
-   **Audit logging**: Track all data changes

### Scalability

-   **Database sharding**: By geographic region
-   **Read replicas**: For improved query performance
-   **Caching strategy**: Redis for frequently accessed data
-   **Search optimization**: Elasticsearch for complex searches
