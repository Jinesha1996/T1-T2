<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Colorful Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4682b4;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .post {
            margin-bottom: 40px;
        }
        .post h2 {
            color: #2e8b57;
        }
        .post p {
            line-height: 1.6;
        }
        footer {
            background-color: #4682b4;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to My Colorful Blog</h1>
</header>

<div class="container">
    <?php
    // Define some example blog posts
    $posts = [
        [
            'title' => 'First Blog Post',
            'content' => 'This is the content of the first blog post. It is simple but effective. Enjoy the colorful presentation!',
        ],
        [
            'title' => 'Another Interesting Post',
            'content' => 'Here is another interesting post. It is a great way to share thoughts and ideas with the world. Keep reading!',
        ],
        [
            'title' => 'Final Thoughts',
            'content' => 'Thank you for visiting the blog. This is the final post for now, but more content will be added soon. Stay tuned!',
        ],
    ];

    // Display the posts
    foreach ($posts as $post) {
        echo '<div class="post">';
        echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
        echo '<p>' . nl2br(htmlspecialchars($post['content'])) . '</p>';
        echo '</div>';
    }
    ?>
</div>

<footer>
    &copy; 2024 My Colorful Blog. All rights reserved.
</footer>

</body>
</html>
