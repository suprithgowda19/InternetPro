# InternetPro – Admin Dashboard & WhatsApp Integration System

InternetPro is a production-grade Laravel application designed to manage ward-wise users, internet installations, service tickets, and **WhatsApp chatbot data integrations** through a secure, role-based admin dashboard.

This system was built for real operational use and handles both internal workflows and external data ingestion via APIs.



##  Core Capabilities

### Admin & User Management
- Role-based access control (Admin / User)
- Ward-wise user and clinic management
- Controlled permissions using policies and guards

### Installation & Service Tracking
- Internet installation records with image uploads
- Automatic service expiry calculation (installation date + validity)
- Routes and cable inventory tracking
- Installation reports and printable views

### Ticketing System
- User-raised service tickets
- Admin resolution workflow with remarks and attachments
- Status tracking (Pending / Resolved / Irrelevant)

### WhatsApp Chatbot Integration (Key Feature)
- WhatsApp bot collects user/service data externally
- Custom APIs receive and validate bot submissions
- Data stored securely in the database
- Integrated admin dashboard for monitoring chatbot activity
- Enables automation without direct user dashboard access

### Reporting & Documentation
- Full user profile PDF generation
- Printable admin and user views
- Single-page A4 formatted reports
- Image embedding in PDFs

---

##  Technical Highlights

- Backend-driven data preparation (no business logic in Blade)
- Clean Eloquent relationships with eager loading
- Secure file uploads using Laravel filesystem
- API-based data ingestion from external systems (WhatsApp bot)
- Validation, authorization, and role isolation enforced
- Scalable structure for future API and bot extensions



## 🛠 Tech Stack

- **Backend:** Laravel (PHP 8+)
- **Database:** MySQL
- **Auth & Roles:** Laravel Auth + Spatie Permissions
- **APIs:** Custom REST APIs for WhatsApp bot integration
- **Storage:** Laravel Filesystem
- **PDF:** DomPDF
- **Frontend:** Blade, Bootstrap



## 📌 Project Scope

This project demonstrates:
- Full backend ownership
- API design and integration
- Admin system architecture
- Real-world automation via WhatsApp bots
- Production-ready Laravel development

-

## Status

✔ Completed  
✔ Actively used  
✔ Production-oriented design
