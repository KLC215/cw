<?php

function success($message)
{
    return "<div class=\"alert alert-dismissible alert-success\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                $message
              </div>";
}

function error($message)
{
    return "<div class=\"alert alert-dismissible alert-danger\">
               <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                $message
            </div>";
}