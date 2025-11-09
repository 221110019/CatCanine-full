<!-- Edit Post Modal -->
<dialog
    id="edit-modal"
    class="modal"
>
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Edit Post</h3>
        <textarea
            id="edit-caption"
            class="textarea textarea-bordered w-full h-24 mb-4"
        ></textarea>
        <div class="modal-action">
            <button
                class="btn btn-ghost"
                onclick="document.getElementById('edit-modal').close()"
            >Cancel</button>
            <button
                id="save-edit"
                class="btn btn-primary"
            >Save</button>
        </div>
    </div>
</dialog>
