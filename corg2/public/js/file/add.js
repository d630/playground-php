//let Add = {
//  //
//  // Add.getActivities
//  //

//  getActivities: function() {
//    $.ajax({
//           type: 'GET',
//           url: '/activities',
//           dataType : 'json',
//           data: {
//             for: 'fetch'
//           }
//    })
//      .done(function(activities) {
//        Add.removeSelectActivities();
//        Add.appendSelectActivities(activities);
//      });
//  },

//  removeSelectActivities: function() {
//    $('#selectActivities').find('option:not(:first)').remove();
//  },

//  appendSelectActivities: function(activities) {
//    $.each(activities, function(k, v) {
//      $('#selectActivities')
//        .append($(`<option class="my-select-option-activities" value="${k}">${k}|${v}</option>`));
//    });
//  },

//  //
//  // Add.form
//  //

//  form: {
//    onReady: function() {
//      $(document).on('mousedown', '#addFile button[id=btnCancel]', Add.form.cancel);
//      $(document).on('click', '#addFile button[id=btnCancel]', File.preventDefault);
//      $(document).on('mousedown', '#addFile button[id=btnReset]', Add.form.reset);
//      $(document).on('click', '#addFile button[id=btnUpload]', Add.form.upload);
//      $(document).on('change', '#addFile input[id=fileUpload]', Add.form.changeFileName);
//      $(document).on('click', '#addFile button[id=btnSubmit]', Add.form.submit);
//    },

//    submit: function(e) {
//      File.preventDefault(e);
//      if ($('#addFile select[id=selectActivities]').val()) {
//        Add.postFile($($('#addFile')[0]).serializeArray());
//      }
//    },

//    cancel: function(e) {
//      File.preventDefault(e);
//      File.togglePage('Fetch', [ 'Add' ]);
//      File.trigger($(`#fileNavLinks a[data-id=${File.id}]`), 'mousedown')
//      File.scrollTop(`#fileNavLinks a[data-id=${File.id}]`);
//      File.trigger($('#addFile button[id=btnReset]'), 'mousedown');
//    },

//    reset: function(e) {
//      File.preventDefault(e);
//      $('.custom-file-label').html('');
//      $('#addFile input').val('');
//      $('#addFile textarea[id=description]').html('');
//      $('#addFile textarea[id=description]').val('');
//      $('#addFile select[id=selectActivities]').val('');

//      $('#addFile input[id=fileUpload]').prop('disabled', false);
//      $('#addFile button[id=btnUpload]').prop('disabled', false);

//      $('#addFile select[id=selectActivities]').prop('disabled', true);
//      $('#addFile select[id=selectActivities]').prop('required', false);
//      $('#addFile input[id=name]').prop('disabled', true);
//      $('#addFile textarea[id=description]').prop('disabled', true);
//      $('#addFile button[id=btnSubmit]').prop('disabled', true);
//    },

//    upload: function(e) {
//      File.preventDefault(e);
//      if ($('#addFile input[id=fileUpload]').val()) {
//        Add.upload($('#addFile')[0]);
//      }
//    },

//    changeFileName: function() {
//      var fileName = $(this).val().replace('C:\\fakepath\\', '');
//      $(this).next('.custom-file-label')
//        .html(fileName);
//    },
//  },

//  upload: function(form) {
//    $.ajax({
//           type: 'POST',
//           contentType: false,
//           processData: false,
//           url: '/files',
//           dataType : 'json',
//           data: new FormData(form)
//    })
//      .always(function(file) {
//        console.log(file);
//        Add.setPostResponse(file['uploaded_file']);
//      });
//  },

//  postFile: function(file) {
//    var _file = {};
//    for (i = 0; i < file.length; i++) {
//      _file[file[i].name] = file[i].value;
//    }
//    _file.tmp_name = File.tmp_name;
//    $.ajax({
//           type: 'POST',
//           url: '/files',
//           dataType : 'json',
//           contentType: 'application/json; charset=UTF-8',
//           processData: false,
//           data: JSON.stringify(_file)
//    })
//      .done(function(r) {
//        var activity_id = $('#addFile select[id=selectActivities]').val();
//        File.getLastFileId(function(id) {
//          File.id = id;
//            $.when(Fetch.getFileNav(File.id))
//              .then(function() {
//                Add.postReference(activity_id, File.id)
//                File.togglePage('Fetch', [ 'Add' ]);
//                File.scrollTop(`#fileNavLinks a[data-id=${File.id}]`);
//                File.trigger($(`#fileNavLinks a[data-id=${File.id}]`), 'mousedown');
//              });
//            File.trigger($('#addFile button[id=btnReset]'), 'mousedown');
//        });
//      });
//  },

//  setPostResponse: function(file) {
//    File.tmp_name = file.tmp_name;

//    $('#addFile input[id=name]').val(file.name);
//    $('#addFile input[id=size]').val(file.size);
//    $('#addFile input[id=mtype]').val(file.type);

//    $('#addFile input[id=fileUpload]').prop('disabled', true);
//    $('#addFile button[id=btnUpload]').prop('disabled', true);

//    $('#addFile select[id=selectActivities]').prop('disabled', false);
//    $('#addFile select[id=selectActivities]').prop('required', true);
//    $('#addFile input[id=name]').prop('disabled', false);
//    $('#addFile textarea[id=description]').prop('disabled', false);
//    $('#addFile button[id=btnSubmit]').prop('disabled', false);
//  },

//  postReference: function(activity_id, file_id) {
//    $.ajax({
//           type: 'POST',
//           url: `/files/${file_id}/references`,
//           dataType : 'json',
//           contentType: 'application/json',
//           data: JSON.stringify([ activity_id  ])
//    })
//      .always(function(f) {
//        console.log(f);
//      });
//  },

//  //
//  // main
//  //

//  main: {
//    init: function() {
//     Add.main.build();
//     Add.main.setEvents();
//    },

//    build: function() {
//      Add.getActivities();
//    },

//    setEvents: function() {
//      Add.form.onReady();
//    },
//  }
//};
