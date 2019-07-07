## Laravel + VueJS Job Application Task (Studydrive GmbH)

I have received [this Studydrive task](https://github.com/AlexioVay/studydrive/blob/master/public/Task.pdf). This is a repository that represents my solution.

I have set up the MySQL tables manually without Laravel schemes or migration. Therefore this step is required:

1. [Create MySQL database tables](https://github.com/AlexioVay/studydrive/blob/master/public/createSQLTables.sql)

2. (Optional) Fill tables:
This step is optional since I have written a little function, `$project->initialize()`, that receives the JSON data from the link stated in the PDF file and migrates it to our database tables: [photos.sql](https://github.com/AlexioVay/studydrive/blob/master/public/studydrive_photos.sql), [photos_likes.sql](https://github.com/AlexioVay/studydrive/blob/master/public/studydrive_photos_likes.sql), [users.sql](https://github.com/AlexioVay/studydrive/blob/master/public/studydrive_users.sql)

## Result:

![studydrive task preview](https://github.com/AlexioVay/studydrive/blob/master/public/studydrive.gif)
