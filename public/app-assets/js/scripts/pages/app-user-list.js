/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
$(function () {
  ('use strict');

  var dtUserTable = $('.user-list-table'),
    newUserSidebar = $('.new-user-modal'),
    newUserForm = $('.add-new-user'),
    select = $('.select2'),
    dtContact = $('.dt-contact');


  var assetPath = '../../../app-assets/',
    userView = 'app-user-view-account.html';

  if ($('body').attr('data-framework') === 'laravel') {
    assetPath = $('body').attr('data-asset-path');
    userView = assetPath + 'app/user/view/account';
  }

  select.each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');
    $this.select2({
      // the following code is used to disable x-scrollbar when click in select input and
      // take 100% width in responsive also
      dropdownAutoWidth: true,
      width: '100%',
      dropdownParent: $this.parent()
    });
  });

var roleIconObj = {
    superadmin: '<i class="fas fa-user-shield font-medium-3 text-primary me-50"></i>',
    admin: '<i class="fas fa-user-cog font-medium-3 text-primary me-50"></i>',
    teacher: '<i class="fas fa-chalkboard-teacher font-medium-3 text-primary me-50"></i>',
    student: '<i class="fas fa-user-graduate font-medium-3 text-primary me-50"></i>',
    guardian: '<i class="fas fa-user-tie font-medium-3 text-primary me-50"></i>',
    librarian: '<i class="fas fa-book-reader font-medium-3 text-primary me-50"></i>',
  };

  // Users List datatable
  if (dtUserTable.length) {
    dtUserTable.DataTable({
        ajax: {
            url: '/get-users',
            type: 'GET',
        },
        columns: [
            { data: '' },
            { data: 'id' },
            { data: 'name' },
            {
                data: 'roles',
                render: function (data, type, full, meta) {
                    if (data && data.length > 0) {
                        var roleIcons = data.map(function(role) {
                            var roleIcon = roleIconObj[role.name.toLowerCase()];
                            if (roleIcon) {
                                return "<span class='text-truncate align-middle'>"+ roleIcon +role.name + '</span>';
                            } else {
                                return role.name;
                            }
                        });

                        return roleIcons.join(', ');
                    } else {
                        return "<span class='text-truncate align-middle'>" + feather.icons['user-x'].toSvg({ class: 'font-medium-3 text-danger' }) + '</span>';
                    }
                }
            },
            { data: 'email' },
            {
                targets: -1,
                render: function (data, type, full, meta) {
                    return (
                      /*   '<div class="btn-group">' +
                        '<a href="users/'+ full.id + '/edit "class="btn btn-sm">' +
                        feather.icons['edit-2'].toSvg({ class: 'font-small-4 me-50' }) +
                        'Edit</a>' +
                        '<button class="btn btn-sm delete-record" data-user-id="' + full.id + '">' +
                        feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                        'Delete</button>' +
                        '</div>' */
                        //
                        '<div class="btn-group">' +
                        '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-end">' +
                        '<a href="users/'+ full.id + '/edit" class="dropdown-item">' +
                        feather.icons['edit-2'].toSvg({ class: 'font-small-4 me-50' }) +
                        'Edit</a>' +
                        '<button class="btn btn-sm delete-record" data-user-id="' + full.id + '">' +
                        feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                        'Delete</button></div>' +
                        '</div>' +
                        '</div>'
                    );
                }
            }
        ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },

      /*   {
          // Actions
          targets: -1,
          title: 'Actions',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="btn-group">' +
              '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
              feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-end">' +
              '<a href="' +
              userView +
              '" class="dropdown-item">' +
              feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
              'Details</a>' +
              '<a href="javascript:;" class="dropdown-item delete-record">' +
              feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
              'Delete</a></div>' +
              '</div>' +
              '</div>'
            );
          }
        } */
      ],
      order: [[0, 'desc']],
      dom:
        '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
        '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
        '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
        '>t' +
        '<"d-flex justify-content-between mx-2 row mb-1"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: 'Search',
        searchPlaceholder: 'Search..'
      },
      displayLength: 25,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['external-link'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [
            {
              extend: 'print',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
              className: 'dropdown-item',
              exportOptions: { columns: [1, 2, 3, 4, 5] }
            },
            {
              extend: 'csv',
              text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [1, 2, 3, 4, 5] }
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [1, 2, 3, 4, 5] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [1, 2, 3, 4, 5] }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [1, 2, 3, 4, 5] }
            }
          ],
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function () {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
            }, 50);
          }
        },
      /*   {
          text: 'Add New User',
          className: 'add-new btn btn-primary',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modals-slide-in'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        } */
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.columnIndex !== 6 // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIdx +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');
            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
          }
        }
      },
      language: {
        paginate: {
          // remove previous & next text from pagination
          previous: '&nbsp;',
          next: '&nbsp;'
        }
      },
      initComplete: function () {
        // Adding role filter once table initialized
        this.api()
        .columns(3)
        .every(function () {
            var column = this;
            var label = $('<label class="form-label" for="UserRole">Role</label>').appendTo('.user_role');
            var select = $(
                '<select id="UserRole" class="form-select text-capitalize mb-md-0 mb-2"><option value=""> Select Role </option></select>'
            )
                .appendTo('.user_role')
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                });

            // Flatten the roles data and get unique roles
            var uniqueRoles = column
                .data()
                .reduce(function (acc, roles) {
                    return acc.concat(roles);
                }, [])
                .filter(function (value, index, self) {
                    return self.indexOf(value) === index;
                })
                .sort();
                uniqueRoles.forEach(function (role) {
                select.append('<option value="' + role.name + '" class="text-capitalize">' + role.name + '</option>');
            });
        });
      }
    });

    dtUserTable.on('click', '.delete-record', function () {
        var userId = $(this).data('user-id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/users/' + userId,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        dtUserTable.DataTable().ajax.reload();
                        toastr['success']('User deleted successfully', 'success', {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                            rtl: 'rtl'
                        });
                    },
                    error: function (error) {
                        console.error('Error deleting user:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                });
            }
        });

    });
}

  // Form Validation
  if (newUserForm.length) {
    newUserForm.validate({
      errorClass: 'error',
      rules: {
        'user-fullname': {
          required: true
        },
        'user-name': {
          required: true
        },
        'user-email': {
          required: true
        }
      }
    });

    newUserForm.on('submit', function (e) {
      var isValid = newUserForm.valid();
      e.preventDefault();
      if (isValid) {
        newUserSidebar.modal('hide');
      }
    });
  }

  // Phone Number
  if (dtContact.length) {
    dtContact.each(function () {
      new Cleave($(this), {
        phone: true,
        phoneRegionCode: 'US'
      });
    });
  }
});
