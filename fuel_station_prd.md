# Fuel Station Web-Based Purchase System (PRD)

## Overview

This system is a web-based fuel purchasing platform similar to an
e-commerce application, designed for fuel stations. Users can
pre-purchase fuel online, receive a digital slip, and redeem it
physically at the fuel station.

## Objectives

-   Enable users to purchase fuel online
-   Enforce vehicle-based fuel limits
-   Provide digital payment via bKash
-   Generate printable/downloadable fuel slips
-   Allow admins to manage inventory, users, and transactions

## User Roles

### Customer (User)

-   Register/Login
-   Add vehicle info
-   Purchase fuel
-   Download/print slip
-   View purchase history

### Admin

-   Secure login (no public registration)
-   Manage categories, products, users, purchases, vehicle rules

## Features

### User Side

#### Authentication

-   Register, Login, Logout

#### Home Page

-   Welcome message
-   Login/Register CTA
-   Fuel availability overview

#### Fuel Categories

-   Octane, Petrol, Diesel

#### Vehicle Verification

-   Vehicle Type
-   Vehicle Number
-   Limits applied based on type

#### Purchase Flow

1.  Select Fuel
2.  Enter Vehicle Info
3.  Validate Limits
4.  View Fuel Details
5.  Payment via bKash
6.  Generate Slip

#### Slip Includes

-   Slip ID
-   User & Vehicle Info
-   Fuel Details
-   Payment Info
-   Date

#### Restrictions

-   Vehicle blocked after purchase for X days
-   One vehicle per type

------------------------------------------------------------------------

### Admin Panel

#### Dashboard

-   Users, Sales, Stock Summary

#### Category Module

-   Add/Delete categories

#### Product Module

-   Add fuel
-   Update price & quantity

#### User Module

-   View/Edit users

#### Purchase Module

-   View transactions
-   Mark as collected

#### Vehicle Limit Module

-   Set max amount, liters, block days

#### Reports

-   Sales, revenue, category-wise reports

------------------------------------------------------------------------

## Database Design

### users

-   id, name, email, password, role, timestamps

### categories

-   id, name, timestamps

### products

-   id, category_id, name, price_per_liter, available_quantity

### vehicles

-   id, user_id, vehicle_type, vehicle_number, is_blocked, blocked_until

### vehicle_limits

-   id, vehicle_type, max_amount, max_liters, block_days

### purchases

-   id, user_id, vehicle_id, product_id, amount_paid, liters, status,
    slip_id

### payments

-   id, purchase_id, transaction_id, payment_status

------------------------------------------------------------------------

## Tech Stack

-   Laravel
-   Blade + Bootstrap
-   MySQL
-   bKash API(implement later now show only the button)
-   DomPDF

------------------------------------------------------------------------

## Business Logic

-   Enforce vehicle limits
-   Prevent duplicate vehicle types
-   Block vehicle after purchase
-   Deduct stock after payment

------------------------------------------------------------------------

## Future Enhancements

-   QR verification
-   Mobile app
-   SMS notifications

------------------------------------------------------------------------

## Success Metrics

-   Daily transactions
-   Payment success rate
-   Stock accuracy
