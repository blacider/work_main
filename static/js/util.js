function trim(str)
{
    return str.replace(/(^\s*)|(\s*$)/g,"");
}

function in_array(arr,val)
{
    for(var i = 0 ; i < arr.length ; i++)
    {
        if(arr[i] == val)
        {
            return true;
        }
    }

    return false;
}

function pop_all_from_array(arr,val)
{
    for(var i = 0 ; i < arr.length ; i++)
    {
        if(arr[i] == val)
        {
            arr.splice(i,1);
        }
    }
}
