
function dupcheck(_type, _url, _data = null, _dataType = 'json', _contentType = 'application/json') {

  $.ajax({
    
    type: _type,
    url:  _url,
    data: _data,
    dataType: _dataType,
    contentType: _contentType,
    
    success: function(result) {
        alert('ok');
    },
    error: function(result) {
        alert('error');
    }
  });
}