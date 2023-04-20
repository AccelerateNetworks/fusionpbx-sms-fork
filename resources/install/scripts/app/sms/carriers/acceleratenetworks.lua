-- arguments = "";
argv = {...}
for key,value in pairs(argv) do
    freeswitch.consoleLog("notice", "[sms] [accelerate-networks] argv["..key.."]: "..argv[key].."\n");
end

local api_url = argv[1];
local username = argv[2];
local access_key = argv[3];
local secret_key = argv[4];
local outbound_caller_id_number = argv[5];
local to = argv[6];
local body = argv[7];

freeswitch.consoleLog("notice", "[sms] [accelerate-networks] sending sms\n");
cmd = "curl -iH 'Authorization: Bearer " .. secret_key .. "' -H \"Content-Type: application/json\" -d '{\"to\":\"" .. to .. "\",\"msisdn\":\"" .. outbound_caller_id_number .."\",\"message\":\"" .. body .. "\"}' " .. api_url;

freeswitch.consoleLog("notice", "[sms] [accelerate-networks] executing " .. cmd .. "\n")
local handle = io.popen(cmd)
local result = handle:read("*a")
handle:close()
freeswitch.consoleLog("notice", "[sms] [accelerate-networks] curl returned: " .. result .. "\n")
