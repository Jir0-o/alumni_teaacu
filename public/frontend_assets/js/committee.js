$(document).ready(function () {
    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Cache DOM elements
    const $committeeSection = $('#committee_section');
    const $committeeMemberSection = $('#committee_member_section');
    
    // Toggle between committee and member sections
    $(document).on('click', '#next_going_to_Committe_member', function () {
        $committeeSection.hide();
        $committeeMemberSection.show();
    });

    $(document).on('click', '#back_button_going_to_committee', function () {
        $committeeSection.show();
        $committeeMemberSection.hide();
    });

    // Committee functions
    function handleCommitteeResponse(response, isUpdate = false) {
        if (response.status == 200) {
            alert("Success: " + response.success);
            if (!isUpdate) {
                $('#new_committee')[0].reset();
            }
            getCommittee();
            // Reload or update the committee list display here
            location.reload();
        } else {
            alert("Error: " + (response.errors || "Something went wrong"));
        }
    }

    // Add Committee
    $('#add_committee').on('click', function (event) {
        event.preventDefault();
        
        const formData = {
            'name': $('#committe_name').val(),
            'from': $('#committe_from').val(),
            'to': $('#committe_to').val(),
            'isActive': $('#committe_isActive').val(),
        };

        $.ajax({
            url: "add-committee",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                handleCommitteeResponse(response);
            },
            error: function(xhr) {
                alert("Error: " + (xhr.responseJSON?.errors || "Request failed"));
            }
        });
    });

    // Edit Committee
    $(document).on('click', '.committee_edit', function () {
        const committeeId = $(this).data('id');
        $('#updateCommittee').modal('show');

        $.ajax({
            type: "GET",
            url: "edit-Committee/" + committeeId,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    $('#update_committe_name').val(response.getdata.name);
                    $('#update_committe_from').val(response.getdata.from);
                    $('#update_committe_to').val(response.getdata.to);
                    $('#update_committe_isActive').val(response.getdata.isActive);
                    $('#committee_id').val(response.getdata.id);
                }
            }
        });
    });

    // Update Committee
    $(document).on('click', '.committee_update', function (event) {
        event.preventDefault();
        const committeeId = $('#committee_id').val();
        const formData = {
            'name': $('#update_committe_name').val(),
            'from': $('#update_committe_from').val(),
            'to': $('#update_committe_to').val(),
            'isActive': $('#update_committe_isActive').val(),
        };

        $('#updateCommittee').modal('hide');
        
        $.ajax({
            url: "update-committee/" + committeeId,
            method: "PUT",
            data: formData,
            dataType: "json",
            success: function (response) {
                handleCommitteeResponse(response, true);
            }
        });
    });

    // Delete Committee
    $(document).on('click', '.committee_delete', function () {
        if (confirm('Are you sure you want to delete this committee?')) {
            const committeeId = $(this).data('id');
            
            $.ajax({
                url: "delete-committee/" + committeeId,
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        alert("Success: " + response.delete);
                        // Reload or update the committee list display here
                    }
                }
            });
        }
    });

    // Get All Committees
    function getCommittee() {
        $.ajax({
            url: "get-all-committee",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.getCommittee) {
                    const $committeeDropdown = $('#committe_ID');
                    const $committeeUpdateDropdown = $('#committe_ID_update');
                    
                    const options = response.getCommittee.map(item => 
                        `<option value="${item.id}">${item.name}</option>`
                    ).join('');
                    
                    $committeeDropdown.html('<option selected disabled>---Select---</option>' + options);
                    $committeeUpdateDropdown.html('<option selected disabled>---Select---</option>' + options);
                }
            }
        });
    }

    // Committee Member functions
    function handleMemberResponse(response) {
        if (response.status == 200) {
            alert("Success: " + response.success);
            $('#committee_member_form')[0].reset();
            // Reload or update the member list display here
            location.reload();
        } else {
            alert("Error: " + (response.errors || "Something went wrong"));
        }
    }

    // Add Committee Member
    $('#committee_member_form').on('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: "add-committee-memeber",
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                handleMemberResponse(response);
            }
        });
    });

    // Edit Committee Member
    $(document).on('click', '.committee_member_edit', function () {
        const memberId = $(this).data('id');
        $('#member_update').modal('show');

        $.ajax({
            type: "GET",
            url: "edit-Committee-member/" + memberId,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    $('#committee_member_name_update').val(response.getdata.committee_member_name);
                    $('#cipsMemberIdUpdate').val(response.getdata.cipsMemberId);
                    $('#position_held_update').val(response.getdata.designation);
                    $('#committe_ID_update').val(response.getdata.committee_id);
                    $('#committee_member_id').val(response.getdata.id);
                }
            }
        });
    });

    // Update Committee Member
    $('#update_committee_memeber').on('submit', function (event) {
        event.preventDefault();
        const memberId = $('#committee_member_id').val();
        const formData = new FormData(this);

        $('#member_update').modal('hide');
        
        $.ajax({
            url: "update-committee-member/" + memberId,
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                handleMemberResponse(response);
            }
        });
    });

    // Delete Committee Member
    $(document).on('click', '.committee_member_delete', function () {
        if (confirm('Are you sure you want to delete this member?')) {
            const memberId = $(this).data('id');
            
            $.ajax({
                url: "delete-committee-member/" + memberId,
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        alert("Success: " + response.delete);
                        // Reload or update the member list display here
                    }
                }
            });
        }
    });

    // Show Committee Member
    $(document).on('click', '.committee_member_show', function () {
        const committeeId = $(this).data('id');
        $('#CommitteeMemberShow').modal('show');

        $.ajax({
            url: "committee-member-show/" + committeeId,
            method: "GET",
            dataType: "json",
            success: function (response) {
                $('#total_member').text(response.totalCommitteeMember);
                
                const membersHtml = response.getCommitteeMember.map((item, index) => `
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td>${item.committee_member_name}</td>
                        <td>${item.cipsMemberId}</td>
                        <td>${item.designation}</td>
                    </tr>
                `).join('');
                
                $('#member_show').html(membersHtml);
            }
        });
    });

    // Toggle Member Visibility
    $(document).on('click', '.committee_member_showCase, .committee_member_showCaseHide', function () {
        const memberId = $(this).data('id');
        const url = $(this).hasClass('committee_member_showCase') ? 
            "member-enable/" + memberId : "member-disabled/" + memberId;
        
        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    alert("Success: " + response.success);
                    // Reload or update the member list display here
                }
            }
        });
    });

    // Initial load
    getCommittee();
});