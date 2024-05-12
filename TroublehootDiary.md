Error: Uncaught SyntaxError: Unexpected token '<'
Solved By: Changing backslash ‘\’ to forward slash ‘/’ in the asset() path of the script source.

Error: Route Model Binding not working, returns instance of the model instead of the model itself.
Solved By: Changing the route parameter name to match the model name with snake case, e.g. for 'TroubleShootDiary' model, the route parameter should be 'trouble_shoot_diary'. Also the variable name in the controller should be the same as the route model name but in camel case, e.g. $troubleShootDiary.