<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Hello {{ $notifiable->name }}</h1>
    <p>A new Proposal is Added to the Project " {{ $proposal->project->title }} " by " {{ $freelancer->name }} "</p>
    <p> <a href="{{ route('projects.show', $proposal->project_id) }}">View Project</a> </p>
    <p>Thank you for using our application</p>
</body>

</html>