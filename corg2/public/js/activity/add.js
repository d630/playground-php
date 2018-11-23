//let Add = {
//  //
//  // Add.getCustomers
//  //

//  getCustomers: function() {
//    $.ajax({
//           type: 'GET',
//           url: '/customers',
//           dataType : 'json',
//           data: {
//             for: 'fetch'
//           }
//    })
//      .done(function(customers) {
//        Add.removeSelectCustomers();
//        Add.appendSelectCustomers(customers);
//      });
//  },

//  removeSelectCustomers: function() {
//    $('#selectCustomers').find('option:not(:first)').remove();
//  },

//  appendSelectCustomers: function(activities) {
//    $.each(activities, function(k, v) {
//      $('#selectCustomers')
//        .append($(`<option class="my-select-option-customers" value="${k}">${k}|${v}</option>`));
//    });
//  },

//  //
//  // Add.form
//  //

//  form: {
//    onReady: function() {
//      $(document).on('submit', '#addActivity', Add.form.submit);
//      $(document).on('mousedown', '#addActivity button[id=btnCancel]', Add.form.cancel);
//      $(document).on('click', '#addActivity button[id=btnCancel]', Activity.preventDefault);
//      $(document).on('mousedown', '#addActivity button[id=btnReset]', Add.form.reset);
//    },

//    submit: function(e) {
//      Activity.preventDefault(e);
//      if ($('#addActivity select[id=selectCustomers]').val() &&
//          $('#addActivity input[id=name]').val())
//      {
//        Add.postActivity($(this).serializeArray());
//      }
//    },

//    cancel: function(e) {
//      Activity.preventDefault(e);
//      Activity.togglePage('Fetch', [ 'Add' ]);
//      Activity.trigger($(`#activityNavLinks a[data-id=${Activity.id}]`), 'mousedown')
//      Activity.scrollTop(`#activityNavLinks a[data-id=${Activity.id}]`);
//    },

//    reset: function(e) {
//      Activity.preventDefault(e);
//      $('#addActivity input').val('');
//      $('#addActivity select').val('');
//      $('#addActivity textarea').val('');
//    }
//  },

//  postActivity: function(activity) {
//    var _activity = {};
//    for (i = 0; i < activity.length; i++) {
//      _activity[activity[i].name] = activity[i].value;
//    }
//    _activity.employee_id = Activity.employeeId;
//    $.ajax({
//           type: 'POST',
//           url: '/activities',
//           dataType : 'json',
//           contentType: 'application/json; charset=UTF-8',
//           processData: false,
//           data: JSON.stringify([_activity])
//    })
//      .done(function() {
//        Activity.getLastActivityId(function(id) {
//          Activity.id = id;
//          $.when(Fetch.getActivityNav(Activity.id))
//            .then(function() {
//              Activity.togglePage('Fetch', [ 'Add' ]);
//              Activity.scrollTop(`#activityNavLinks a[data-id=${Activity.id}]`);
//              Activity.trigger($(`#activityNavLinks a[data-id=${Activity.id}]`), 'mousedown');
//            });
//          Activity.trigger($('#addActivity button[id=btnReset]'), 'mousedown');
//        });
//      });
//  },

//  //
//  // main
//  //

//  main: {
//   init: function() {
//      Add.main.setEvents();
//      Add.main.build();
//    },

//    build: function() {
//      Add.getCustomers();
//    },

//    setEvents: function() {
//      Add.form.onReady();
//    },
//  }
//};

