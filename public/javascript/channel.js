window.addEventListener('load', init);

function init() {
    const channelDetails = document.querySelector('.channelDetails');

    const deleteButton = document.createElement("button");
    deleteButton.innerText = 'Delete account';
    deleteButton.id = 'deleteBtn';

    channelDetails.appendChild(deleteButton);

    deleteButton.addEventListener("click", async () => {
        if (!confirm("Weet je zeker dat je je account wilt verwijderen?")) return;

    });
}
