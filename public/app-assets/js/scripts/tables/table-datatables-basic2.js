/**
 * DataTables Basic
 */

$(function () {
  'use strict';

  var dt_basic_table = $('.datatables-basic'),
    dt_date_table = $('.dt-date'),
    // dt_complex_header_table = $('.dt-complex-header'),
    // dt_row_grouping_table = $('.dt-row-grouping'),
    // dt_multilingual_table = $('.dt-multilingual'),
    assetPath = '../../../app-assets/';

  if ($('body').attr('data-framework') === 'laravel') {
    assetPath = $('body').attr('data-asset-path');
  }

  // DataTable with buttons
  // --------------------------------------------------------------------

  if (dt_basic_table.length) {
    var dt_basic = dt_basic_table.DataTable({
      // ajax: assetPath + 'data/table-datatable.json',
      columnDefs: [
        {
          // Actions
          targets: -1,
          title: 'Actions',
          orderable: false,
          // render: function (data, type, full, meta) {
          //   return (
          //     '<div class="d-inline-flex">' +
          //     '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
          //     feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
          //     '</a>' +
          //     '<div class="dropdown-menu dropdown-menu-end">' +
          //     '<a href="javascript:;" class="dropdown-item">' +
          //     feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
          //     'Details</a>' +
          //     '<a href="javascript:;" class="dropdown-item">' +
          //     feather.icons['archive'].toSvg({ class: 'font-small-4 me-50' }) +
          //     'Archive</a>' +
          //     '<a href="javascript:;" class="dropdown-item delete-record">' +
          //     feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
          //     'Delete</a>' +
          //     '</div>' +
          //     '</div>' +
          //     '<a href="index2.html" class="item-edit">' +
          //     feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
          //     '</a>'
          //   );
          // }
        }
      ],
      order: [[0, 'asc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 25,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        // {
        //   text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Record',
        //   className: 'create-new btn btn-primary',
        //   attr: {
        //     'data-bs-toggle': 'modal',
        //     'data-bs-target': '#modals-slide-in'
        //   },
        //   init: function (api, node, config) {
        //     $(node).removeClass('btn-secondary');
        //   }
        // }
      ],

      language: {
        paginate: {
          // remove previous & next text from pagination
          previous: '&nbsp;',
          next: '&nbsp;'
        }
      }
    });
  }


  // Add New record
  // ? Remove/Update this code as per your requirements ?
  // var count = 101;
  // $('.data-submit').on('click', function () {
  //   var $new_name = $('.add-new-record .dt-full-name').val(),
  //     $new_post = $('.add-new-record .dt-post').val(),
  //     $new_email = $('.add-new-record .dt-email').val(),
  //     $new_date = $('.add-new-record .dt-date').val(),
  //     $new_salary = $('.add-new-record .dt-salary').val();

  //   if ($new_name != '') {
  //     dt_basic.row
  //       .add({
  //         responsive_id: null,
  //         id: count,
  //         full_name: $new_name,
  //         post: $new_post,
  //         email: $new_email,
  //         start_date: $new_date,
  //         salary: '$' + $new_salary,
  //         status: 5
  //       })
  //       .draw();
  //     count++;
  //     $('.modal').modal('hide');
  //   }
  // });

  // // Delete Record
  // $('.datatables-basic tbody').on('click', '.delete-record', function () {
  //   dt_basic.row($(this).parents('tr')).remove().draw();
  // });


});
