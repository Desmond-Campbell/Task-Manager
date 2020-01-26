							<button class="btn btn-sm btn-secondary" @click="completeTask(task); refresh()" v-if="!task.completed"><i class="fa fa-check hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Done') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="incompleteTask(task); refresh()" v-if="task.completed"><i class="fa fa-window-close hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Not Done') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="enlistTask(task)" v-show="!task.working"><i class="fa fa-play hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Enlist') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="delistTask(task)" v-show="task.working"><i class="fa fa-stop hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Delist') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="reprioritiseTask(task)"><i class="fa fa-exclamation hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Re-prioritise') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="rescheduleTask(task)"><i class="fa fa-clock hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Re-schedule') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="reassignTask(task)"><i class="fa fa-user hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Re-assign') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="followupTask(task)"><i class="fa fa-share hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Follow-up') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="cancelTask(task)"><i class="fa fa-times hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Cancel') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="duplicateTask()"><i class="fa fa-copy hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Duplicate') }}</span></button>

