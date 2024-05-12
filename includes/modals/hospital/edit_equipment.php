<!-- Edit Equipment Modal -->
<div id="edit_equipment" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Equipment Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_equipment_form" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="equipment_name">Equipment Name</label>
                                <input type="text" class="form-control" id="equipment_name" name="equipment_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" id="save_changes_button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#edit_equipment').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var equipmentName = button.data('equipment-name'); // Extract equipment name from data attribute
    var description = button.data('description'); // Extract description from data attribute

    console.log("Equipment Name: " + equipmentName); // Debugging statement
    console.log("Description: " + description); // Debugging statement

    // Update modal fields with the extracted data
    var modal = $(this);
    modal.find('#equipment_name').val(equipmentName);
    modal.find('#description').val(description);
    // Add similar lines for other fields if needed
});
</script>