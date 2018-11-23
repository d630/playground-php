//let Add = {

//  //
//  // Add.form
//  //

//  form: {
//    onReady: function() {
//      $(document).on('submit', '#addOrg', Add.form.submit);
//      $(document).on('mousedown', '#addOrg button[id=btnCancel]', Add.form.cancel);
//      $(document).on('click', '#addOrg button[id=btnCancel]', Customer.preventDefault);
//      $(document).on('mousedown', '#addOrg button[id=btnReset]', Add.form.reset);
//    },

//    submit: function(e) {
//      Customer.preventDefault(e);
//      Add.postCustomer($(this).serializeArray());
//    },

//    cancel: function(e) {
//      Customer.preventDefault(e);
//      Customer.togglePage('Fetch', [ 'Add', 'Edit' ]);
//      Customer.trigger($(`#orgNavLinks a[data-id=${Customer.id}]`), 'mousedown')
//      Customer.scrollTop(`#orgNavLinks a[data-id=${Customer.id}]`);
//    },

//    reset: function(e) {
//      Customer.preventDefault(e);
//      $('#addOrg input').val('');
//      $('#addOrg input[id=org]')
//        .removeClass('is-valid')
//        .removeClass('is-invalid');
//      $('#addOrg div[id=orgFeedback]')
//        .replaceWith('<div id="orgFeedback"></div>');
//    }
//  },

//  postCustomer: function(customer) {
//    var _customer = {};
//    for (i = 0; i < customer.length; i++) {
//      _customer[customer[i].name] = customer[i].value;
//    }
//    _customer.employee_id = Customer.employeeId;
//    $.ajax({
//           type: 'POST',
//           url: '/customers',
//           dataType: 'json',
//           contentType: 'application/json; charset=UTF-8',
//           processData: false,
//           data: JSON.stringify(_customer)
//    })
//      .done(function() {
//        Customer.getLastCustomerId(function(id) {
//          Customer.id = id;
//          $.when(Fetch.getCustomerNav(Customer.id))
//            .then(function() {
//              Customer.togglePage('Fetch', [ 'Add', 'Edit' ]);
//              Customer.scrollTop(`#orgNavLinks a[data-id=${Customer.id}]`);
//              Customer.trigger($(`#orgNavLinks a[data-id=${Customer.id}]`), 'mousedown');
//            });
//          Customer.trigger($('#addOrg button[id=btnReset]'), 'mousedown');
//        });
//      });
//  },

//  //
//  // Add.input
//  //

//  input: {
//    onReady: function() {
//      $(document).on('input', '#addOrg input[id=org]', Add.input.validate);
//      $(document).on('focusout', '#addOrg input[id=org]', Add.input.validate);
//    },

//    validate: function(e) {
//      let v = $(this).val();
//      if (v) {
//        Add.input.isOrgUnique(v);
//      } else {
//        Add.input.orgIsValid(false);
//      }
//    },

//    isOrgUnique: function(org) {
//      $.ajax({
//             type: 'GET',
//             url: '/customers/infos/1',
//             dataType : 'json',
//             data: {
//               q: org
//             }
//      })
//        .done(function(response) {
//          if (response) {
//            Add.input.orgIsValid(false);
//          } else {
//            Add.input.orgIsValid(true);
//          }
//        })
//    },

//    orgIsValid: function(b) {
//      if (b) {
//        $('#addOrg input[id=org]')
//          .addClass('is-valid')
//          .removeClass('is-invalid');
//        $('#addOrg div[id=orgFeedback]')
//          .replaceWith('<div class="valid-feedback" id="orgFeedback">org is unique</div>');
//        $('#addOrg button[id=btnSubmit]').prop('disabled', false);
//      } else {
//        $('#addOrg input[id=org]')
//          .removeClass('is-valid')
//          .addClass('is-invalid');
//        $('#addOrg div[id=orgFeedback]')
//          .replaceWith('<div class="invalid-feedback" id="orgFeedback">org is not unique</div>');
//        $('#addOrg button[id=btnSubmit]').prop('disabled', true);
//      }
//    }
//  },

//  //
//  // main
//  //

//  main: {
//   init: function() {
//      Add.main.setEvents();
//    },

//    setEvents: function() {
//      Add.form.onReady();
//      Add.input.onReady();
//    },
//  }
//};
