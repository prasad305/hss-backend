<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('quizDataSubmit') }}">
        @csrf
        <p>Please select your favorite Web language:</p>
        <input type="hidden" name="quiz_question" value="Please select your favorite Web language:">


        <input type="hidden" name="email" required="" value="{{ $User->email }}">
        <input type="hidden" name="phone" required="" value={{ $User->phone }}>

        <input type="radio" id="html" name="quiz_valu" value="HTML">

        <label for="html">HTML</label><br>

        <input type="radio" id="css" name="quiz_valu" value="CSS">

        <label for="css">CSS</label><br>

        <input type="radio" id="javascript" name="quiz_valu" value="JavaScript">

        <label for="javascript">JavaScript</label>
        <br>
        <input type="submit" value="Submit">
    </form>




</body>

</html>
