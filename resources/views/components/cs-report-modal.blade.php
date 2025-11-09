<!-- Report Modal -->
<dialog
    id="report-modal"
    class="modal"
>
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Report Post</h3>
        <textarea
            id="report-reason"
            class="textarea textarea-bordered w-full h-24 mb-4"
            placeholder="Please provide the reason for reporting this post..."
        ></textarea>
        <div class="modal-action">
            <button
                class="btn btn-ghost"
                onclick="document.getElementById('report-modal').close()"
            >Cancel</button>
            <button
                id="submit-report"
                class="btn btn-error"
            >Submit Report</button>
        </div>
    </div>
</dialog>
