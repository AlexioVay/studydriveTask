# Laravel + VueJS Job Application Task (Studydrive GmbH)

This is a repository that presents my solution to the following task:
https://github.com/AlexioVay/studydrive/blob/master/public/Task.pdf

I have set up the MySQL tables manually without Laraval schemes. Therefore this step is required:

1. Create MySQL database tables:

https://github.com/AlexioVay/studydrive/blob/master/public/createSQLTables.sql

2. Fill tables (optional):
This step is optional since I have written a little function, $project->initialize(), that receives the JSON data from the link stated in the PDF file and migrates it to our database tables.

https://github.com/AlexioVay/studydrive/blob/master/public/studydrive_photos.sql
https://github.com/AlexioVay/studydrive/blob/master/public/studydrive_photos_likes.sql
https://github.com/AlexioVay/studydrive/blob/master/public/studydrive_users.sql

3. Result:

![studydrive task preview](https://github.com/AlexioVay/studydrive/blob/master/public/studydrive.gif)
