//let Edit = {
//  //
//  // Edit.form
//  //

//  form: {
//    onReady: function() {
//      $(document).on('submit', '#editOrg', Edit.form.submit);
//      $(document).on('mousedown', '#editOrg button[id=btnCancel]', Edit.form.cancel);
//      $(document).on('click', '#editOrg button[id=btnCancel]', Customer.preventDefault);
//      $(document).on('mousedown', '#editOrg button[id=btnReset]', Edit.form.reset);
//    },

//    submit: function(e) {
//      Customer.preventDefault(e);
//      Edit.putCustomer($(this).serializeArray());
//    },

//    cancel: function(e) {
//      Customer.preventDefault(e);
//      Customer.togglePage('Fetch', [ 'Add', 'Edit' ]);
//      Customer.trigger($(`#orgNavLinks a[data-id=${Customer.id}]`), 'mousedown')
//      Customer.scrollTop(`#orgNavLinks a[data-id=${Customer.id}]`);
//    },

//    reset: function(e) {
//      Customer.preventDefault(e);
//      $('#editOrg input').val('');
//    },

//  },

//  putCustomer: function(customer) {
//    $.ajax({
//           type: 'PUT',
//           url: '/customers/' + Customer.id,
//           dataType : 'json',
//           data: JSON.stringify(customer)
//    })
//      .done(function() {
//        Customer.trigger($('#editOrg button[id=btnCancel]'), 'mousedown');
//      });
//  },

//  setCustomer: function(customer) {
//    $('#orgNameHeading').html('Edit Customer ' + customer.org);
//    //TODO
//    // Customer.setDocumentTitle('Edit Customer ' + customer.org);

//    $('#editOrg input[id=url]').attr('value', customer.url);
//    $('#editOrg input[id=post_office_box]').attr('value', customer.post_office_box);
//    $('#editOrg input[id=street_address]').attr('value', customer.street_address);
//    $('#editOrg input[id=extended_address]').attr('value', customer.extended_address);
//    $('#editOrg input[id=locality]').attr('value', customer.locality);
//    $('#editOrg input[id=region]').attr('value', customer.region);
//    $('#editOrg input[id=postal_code]').attr('value', customer.postal_code);
//    $('#editOrg input[id=country_name]').attr('value', customer.country_name);
//    $('#editOrg input[id=role]').attr('value', customer.role);
//    $('#editOrg input[id=family_name]').attr('value', customer.family_name);
//    $('#editOrg input[id=given_name]').attr('value', customer.given_name);
//    $('#editOrg input[id=additional_name]').attr('value', customer.additional_name);
//    $('#editOrg input[id=honorific_prefix]').attr('value', customer.honorific_prefix);
//    $('#editOrg input[id=honorific_suffix]').attr('value', customer.honorific_suffix);
//    $('#editOrg input[id=tel]').attr('value', customer.tel);
//    $('#editOrg input[id=email]').attr('value', customer.email);
//  },

//  //
//  // Edit.main
//  //

//  main: {
//    init: function() {
//      Edit.main.setEvents();
//    },

//    setEvents: function() {
//      Edit.form.onReady();
//    }
//  }
//};
