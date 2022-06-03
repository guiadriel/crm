const CustomDialog = {
  confirm: function(text, callback) {
    bootbox.confirm({
        title: "",
        message: `${text}`,
        centerVertical: true,
        buttons: {
            cancel: {
                className:'d-flex align-items-center',
                label: '<i class="material-icons m-0 p-0">close</i> Cancelar'
            },
            confirm: {
                className: 'btn btn-primary d-flex align-items-center',
                label: '<i class="material-icons m-0 p-0">done</i> Confirmar'
            }
        },
        callback: function (result) {
          (callback) && callback(result);
        }
    });
  },
  submit: function(message, self, callback){
    event.preventDefault();
    this.confirm(message, res => {
      if( res ){
        self.submit();
        (callback) && callback(true);
      }
    });
  }
}

module.exports = CustomDialog;
