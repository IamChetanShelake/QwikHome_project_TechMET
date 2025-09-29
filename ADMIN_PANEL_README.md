# QwikHome Admin Panel

A comprehensive, responsive admin panel for the QwikHome service platform with a modern black, gray, and white design theme.

## Features

### 🔐 Authentication & Roles
- Secure login system with role-based access
- Super Admin and Sub Admin roles
- Session management and remember me functionality

### 📊 Dashboard Overview
- Real-time statistics and KPIs
- Revenue tracking and booking metrics
- Active users and pending approvals
- Interactive charts and graphs

### 👥 User Management
- Customer management (view, edit, block/unblock)
- Service provider management (approve/reject/suspend)
- KYC document verification
- User activity tracking

### 🛠️ Service Management
- Add/Edit/Delete service categories
- Pricing and VAT settings management
- Service provider assignment
- Service availability controls

### 📅 Booking Management
- View all bookings with filters
- Assign/Reassign service providers
- Real-time booking status monitoring
- Booking history and analytics

### 💰 Finance & Wallet
- Payment tracking and settlements
- Commission management per service
- Refund processing
- Financial reporting and analytics

### 🎟️ Coupons & Promotions
- Create and manage discount coupons
- Promotional campaigns
- Usage tracking and analytics
- Bulk coupon operations

### 🔔 Notifications
- Push notifications to customers/providers
- Notification templates
- Delivery tracking and analytics
- Bulk messaging capabilities

### 📈 Reports & Analytics
- Comprehensive booking reports
- Revenue analysis and trends
- Provider performance metrics
- User engagement analytics

### 🎯 Complaints & Disputes
- Customer and provider complaint handling
- Resolution status tracking
- Priority-based complaint management
- Dispute resolution workflow

### 📝 Content Management
- Banner management for homepage
- FAQ management system
- Promotional offers management
- Static page content (Terms, Privacy, About)

### 🎯 Lead Management
- Manual lead entry system
- Lead tracking and follow-ups
- Conversion tracking
- Lead pipeline management

## Design Features

### 🎨 Modern UI/UX
- **Vibrant Color Scheme**: Black, gray, and white with cyan accents
- **Glassmorphism Effects**: Transparent backgrounds with blur effects
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **Smooth Animations**: Hover effects and transitions
- **Intuitive Navigation**: Collapsible sidebar with clear icons

### 📱 Responsive Design
- Mobile-first approach
- Adaptive layouts for all screen sizes
- Touch-friendly interface elements
- Optimized for various devices

## Technical Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: Laravel 10+
- **Styling**: Custom CSS with modern features
- **Icons**: Font Awesome 6
- **Fonts**: Inter (Google Fonts)

## File Structure

```
resources/views/admin/
├── dashboard.blade.php    # Main admin dashboard
└── login.blade.php        # Admin login page

public/css/
└── admin.css             # Admin panel styles

public/js/
└── admin.js              # Admin panel functionality

routes/
└── web.php               # Admin routes
```

## Installation & Setup

1. **Access the Admin Panel**:
   ```
   http://your-domain.com/admin/login
   ```

2. **Demo Credentials**:
   - Email: `admin@qwikhome.com`
   - Password: `admin123`

3. **Routes Available**:
   - `/admin/login` - Admin login page
   - `/admin` - Main admin dashboard

## Key Features Breakdown

### Dashboard Statistics
- Total Bookings with growth percentage
- Revenue tracking with trends
- Active user count
- Pending approvals counter

### User Management
- Comprehensive user listing with filters
- User status management (Active/Blocked/Pending)
- Role-based user categorization
- Bulk user operations

### Service Management
- Service category management
- Pricing configuration
- Provider assignment tools
- Service availability controls

### Booking Operations
- Real-time booking monitoring
- Status tracking (Pending/In Progress/Completed)
- Provider assignment and reassignment
- Booking analytics and reporting

### Financial Management
- Revenue tracking and analysis
- Commission rate configuration
- Payment settlement management
- Refund processing workflow

## Customization

The admin panel is designed to be easily customizable:

1. **Colors**: Modify CSS variables in `admin.css`
2. **Layout**: Adjust grid systems and responsive breakpoints
3. **Content**: Update dummy data in `admin.js`
4. **Features**: Add new sections by extending the JavaScript content system

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Performance Features

- **Optimized Loading**: Lazy loading for content sections
- **Smooth Animations**: Hardware-accelerated CSS transitions
- **Responsive Images**: Optimized for different screen densities
- **Efficient JavaScript**: Modular code structure

## Security Features

- Role-based access control
- Secure authentication flow
- Session management
- Input validation and sanitization

## Future Enhancements

- Real-time notifications
- Advanced analytics dashboard
- Multi-language support
- Dark/Light theme toggle
- Advanced filtering and search
- Export functionality for reports
- Integration with external APIs

## Support

For any issues or customization requests, please refer to the Laravel documentation or contact the development team.

---

**QwikHome Admin Panel** - Built with ❤️ for efficient service management.
