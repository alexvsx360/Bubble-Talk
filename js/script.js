
$('.delete-post-btn').on('click', function () {

  if (confirm('Are you sure you want to delete this post?')) {

    return true;

  } else {

    return false;

  }


});