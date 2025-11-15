
db.tasks.createIndex({ ownerId: 1, status: 1, priority: 1, dueDate: -1 }, { name: 'owner_status_priority_dueDate' });

// separate helpful single-field indexes
db.tasks.createIndex({ ownerId: 1 }, { name: 'ownerId_1' });
db.tasks.createIndex({ status: 1 }, { name: 'status_1' });
db.tasks.createIndex({ priority: 1 }, { name: 'priority_1' });
db.tasks.createIndex({ dueDate: -1 }, { name: 'dueDate_-1' });

// text search on title/description for ?q= queries
db.tasks.createIndex({ title: 'text', description: 'text' }, { name: 'text_title_description', weights: { title: 5, description: 1 } });
