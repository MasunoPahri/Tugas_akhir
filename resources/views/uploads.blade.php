<form action="/WEB/uploads/sendFiles" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="file" name="file[]" multiple>
    <input type="submit">
</form>