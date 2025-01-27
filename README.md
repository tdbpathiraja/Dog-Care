
# Dog Care

Animal Clinic Appoinment Sheduling Website


[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)
![Static Badge](https://img.shields.io/badge/tdbpathiraja-blue?style=flat&label=Created%20By)



## Features

- User Account (Upadate Profile Image , Delete Profile Image , Reset Password , Change Name, Change Email Address , Book a Appoinments , Upcoming Appoinments , Delete Appoinments , Edit Appoinments)
- Admin Dashboard (Quick Stats for Users , Bookings , Doctors , Feedbacks , Table preview for bookings , Manage Feedbacks , Manage Users , Manage Doctors , Manage Appoinments , Send Message)
- Book Appoinments (Registed or Non Registed Users)
- Feedback Form (Regsited Users)
- Admin and User Login
- Email Notification System for Account Creation , Appoinments Sheduling , Send Message


## Tech Stack

**Client:** HTML , CSS , Js

**Server:** PHP

**Database :** My SQL

**Libraries :** PHP Mailer , ChartJs , FontAwsome


## Installation

You need to add your own email address and app password to work the email notificatin system. to get the email app password please watch this [video](https://www.youtube.com/watch?v=MkLX85XU5rU) and create your app password.

After creating your app password you need to add your email and app password in `src/scripts/admin-functions/add-user.php` , `src/scripts/admin-functions/send-message.php` , `src/scripts/user-functions/save-appoinments.php` pages below lines

Same structure is maintaining in these three pages so you can easily find the lines and I added comments on that lines to easily find.

```bash
  $mail->Username = 'YOUR_EMAIL_ADDRESS';
  $mail->Password = 'YOUR_APP_PASSWORD';
```

## Support

For support, email tdbpathiraja@gmail.com

