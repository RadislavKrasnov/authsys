<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script src="/js/validation/validation_rules.js"></script>
        <script src="/js/validation/validate.js"></script>
        <?php $this->head($view) ?>
    </head>
    <body>
        <?php $this->show($view, $data) ?>
    </body>
</html>
