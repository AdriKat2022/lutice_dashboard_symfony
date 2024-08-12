// Get the button that calculates user activities
const computeButton = document.getElementById('calculate-user-activities');
if (computeButton) {
    computeButton.addEventListener('click', computeUserActivities);
}

// Assign to all checkboxes the same event listener
const checkboxes = document.querySelectorAll('.calculate-user-option-checkbox');
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', computeUserActivities);
});

document.addEventListener('DOMContentLoaded', function() {
    computeUserActivities();
});

function computeUserActivities() {
    // Get max values
    let maxOnlineTime = 0;
    let maxTalkTime = 0;
    let maxMessageCount = 0;
    let maxEmojis = 0;
    let maxRaisedHand = 0;

    courses_json_data.forEach(user => {
        // alert(user);
        maxOnlineTime = Math.max(maxOnlineTime, user.onlineTime);
        maxTalkTime = Math.max(maxTalkTime, user.talkTime);
        maxMessageCount = Math.max(maxMessageCount, user.messageCount);

        let userEmojis = 0;
        let userHands = 0;
        if (user.emojis) {
            Object.keys(user.emojis).forEach(name => {
                if (name === 'raiseHand') {
                    userHands += user.emojis[name].count;
                } else {
                    userEmojis += user.emojis[name].count;
                }
            });
        }

        maxEmojis = Math.max(maxEmojis, userEmojis);
        maxRaisedHand = Math.max(maxRaisedHand, userHands);
    });

    courses_json_data.forEach(user => {
        let onlineTimePoints = maxOnlineTime === 0 ? 0 : 2 * user.onlineTime / maxOnlineTime;
        let talkTimePoints = maxTalkTime === 0 ? 0 : 2 * user.talkTime / maxTalkTime;
        let messageCountPoints = maxMessageCount === 0 ? 0 : 2 * user.messageCount / maxMessageCount;
        let emojisPoints = 0;
        let raisedHandPoints = 0;

        let totalEmojis = 0;
        if (user.emojis) {
            Object.keys(user.emojis).forEach(name => {
                if (name !== 'raiseHand') {
                    totalEmojis += user.emojis[name].count;
                } else {
                    raisedHandPoints = maxRaisedHand === 0 ? 0 : 2 * user.emojis[name].count / maxRaisedHand;
                }
            });
            emojisPoints = maxEmojis === 0 ? 0 : 2 * totalEmojis / maxEmojis;
        }

        // Include factors based on user choices
        // The maximum value after the sum must always be 10
        let activityLevel = 0;
        let total_factors = 0;
        const onlineTimeCheckbox = document.getElementById('online-time-checkbox');
        const talkTimeCheckbox = document.getElementById('talk-time-checkbox');
        const messageCountCheckbox = document.getElementById('message-count-checkbox');
        const emojisCheckbox = document.getElementById('emojis-checkbox');
        const raisedHandCheckbox = document.getElementById('raised-hand-checkbox');

        if (onlineTimeCheckbox.checked) {
            activityLevel += onlineTimePoints;
            total_factors += 1;
        }
        if (talkTimeCheckbox.checked) {
            activityLevel += talkTimePoints;
            total_factors += 1;
        }
        if (messageCountCheckbox.checked) {
            activityLevel += messageCountPoints;
            total_factors += 1;
        }
        if (emojisCheckbox.checked) {
            activityLevel += emojisPoints;
            total_factors += 1;
        }
        if (raisedHandCheckbox.checked) {
            activityLevel += raisedHandPoints;
            total_factors += 1;
        }

        if (total_factors > 0) {
            activityLevel /= total_factors/5;
            
            
            // Update the DOM
            const activityElement = document.getElementById(`activity-level-${user.id}`);
            // alert(`activity-level-${user.id}`);
            // alert(activityElement);
            if (activityElement) {
                let html = '';
                for (let i = 1; i <= 10; i++) {
                    if (activityLevel >= (i - 0.45)) {
                        html += '<i class="bi bi-circle-fill me-1"></i>';
                    } else {
                        html += '<i class="bi bi-circle me-1"></i>';
                    }
                }
                html += `<span class="badge rounded-full text-bg-secondary ms-1">${activityLevel.toFixed(1)}</span>`;
                activityElement.innerHTML = html;
            }
        }
        else {
            // Update the DOM
            const activityElement = document.getElementById(`activity-level-${user.id}`);
            if (activityElement) {
                activityElement.innerHTML = '';
                activityElement.innerHTML += `<span class="badge rounded-full text-bg-secondary ms-1">Non défini</span>`;
            }
        }
    });
}
