<!-- Modal -->
<div class="modal fade" id="add_equipment_userside" tabindex="-1" role="dialog" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEquipmentModalLabel">Add Equipment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for adding equipment -->
        <form id="addEquipmentForm" method="POST" action="add-equipment-userside-save.php" enctype="multipart/form-data">
          <div class="form-row">
            <!-- Initial dropdown -->
            <div class="form-group col-md-6">
                <label for="hospital-equipment">Enter Medical Equipment</label>
                <input type="text" name="hospital_equipment[]" class="form-control" required placeholder="Medical Equipment">
            </div>
            <div class="form-group col-md-6">
                <label for="hospital-equipment">Description</label>
                <textarea name="hospital_equipment_description" class="form-control" rows="1" required placeholder="Enter description"></textarea>
            </div>
            <!-- Purchase Date -->
            <div class="form-group col-md-6">
                <label for="purchase-date">Purchase Date</label>
                <input type="date" name="purchase_date" class="form-control" required>
            </div>
            <!-- Location in the Hospital -->
            <div class="form-group col-md-6">
                <label for="location">Location in the Hospital</label>
                <input type="text" name="location" class="form-control" required placeholder="Location">
            </div>
            <!-- Serial Number -->
            <div class="form-group col-md-6">
                <label for="serial-number">Serial Number</label>
                <input type="text" name="serial_number" class="form-control" required placeholder="Serial Number">
            </div>
            <!-- Model Number -->
            <div class="form-group col-md-6">
                <label for="model-number">Model Number</label>
                <input type="text" name="model_number" class="form-control" required placeholder="Model Number">
            </div>
            <div class="form-group col-md-6">
                <label for="equipment-status">Equipment Status</label>
                <select name="equipment_status" class="form-control" required>
                    <option value="" disabled selected>Select Equipment Status</option>
                    <option value="Available">Available</option>
                    <option value="In Use">In Use</option>
                    <option value="Under Maintenance">Under Maintenance</option>
                    <option value="Out of Order">Out of Order</option>
                    <option value="Needs Replacement">Needs Replacement</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Image</label>
                        <input name="image" type="file" class="form-control" required="true" autocomplete="off">
                    </div>
                </div>
            </div>
          </div>
          <!-- Additional form elements can be added here -->
          <!-- For example, if you need to add more fields for equipment details -->
          <!-- <div class="form-row"> ... </div> -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Equipment</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
