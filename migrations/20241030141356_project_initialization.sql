-- migrate:up
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    scheduled_at DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    max_attendees INT NOT NULL
);

CREATE TABLE attendees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NULL,
    email VARCHAR(255) NOT NULL,
    INDEX (email)
);

CREATE TABLE events_attendees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    attendee_id INT NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (attendee_id) REFERENCES attendees(id) ON DELETE CASCADE,
    UNIQUE INDEX (event_id, attendee_id)
);

-- migrate:down
DROP TABLE events;
DROP TABLE attendees;
DROP TABLE events_attendees;
